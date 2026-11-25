<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderCancellationService
{
    private const CUSTOMER_CANCELLABLE_STATUSES = ['pending', 'confirmed', 'processing'];

    public function cancelByCustomer(int $orderId, string $actor, string $reason): string
    {
        return $this->cancel(
            $orderId,
            self::CUSTOMER_CANCELLABLE_STATUSES,
            $actor,
            'Order cancelled by customer',
            $reason
        );
    }

    public function cancelByAdmin(int $orderId, string $actor, ?string $notes): string
    {
        $allowedStatuses = array_values(array_diff(array_keys(Order::STATUSES), ['delivered', 'cancelled']));

        return $this->cancel(
            $orderId,
            $allowedStatuses,
            $actor,
            Order::STATUSES['cancelled'],
            $notes
        );
    }

    private function cancel(int $orderId, array $allowedStatuses, string $actor, string $title, ?string $notes): string
    {
        return DB::transaction(function () use ($orderId, $allowedStatuses, $actor, $title, $notes): string {
            $order = Order::whereKey($orderId)->lockForUpdate()->firstOrFail();

            if ($order->payment_status === 'collected') {
                return 'collected';
            }

            if ($order->status === 'cancelled') {
                return 'unchanged';
            }

            if (!in_array($order->status, $allowedStatuses, true)) {
                return 'not_allowed';
            }

            $items = $order->items()
                ->where('stock_tracked', true)
                ->whereNotNull('product_id')
                ->orderBy('product_id')
                ->get();

            foreach ($items as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();
                if ($product && $product->stock_quantity !== null) {
                    $product->increment('stock_quantity', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
            OrderEvent::create([
                'order_id' => $order->id,
                'status' => 'cancelled',
                'title' => $title,
                'notes' => $notes,
                'actor' => $actor,
            ]);

            return 'cancelled';
        });
    }
}
