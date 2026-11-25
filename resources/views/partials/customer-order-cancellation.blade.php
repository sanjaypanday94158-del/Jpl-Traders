@if(in_array($order->status, ['pending', 'confirmed', 'processing'], true) && $order->payment_status !== 'collected')
    <section class="order-cancellation-panel" aria-labelledby="orderCancellationHeading">
        <div>
            <p class="cart-eyebrow">ORDER OPTIONS</p>
            <h2 id="orderCancellationHeading">Need to cancel this order?</h2>
            <p>You can cancel before the order is shipped. Your order status and tracked stock will update immediately.</p>
        </div>
        <form action="{{ $action }}" method="POST" class="order-cancellation-form" data-confirm="Cancel this order? This action cannot be undone.">
            @csrf
            <label for="cancellationReason">Reason for cancellation <span>(required)</span></label>
            <textarea id="cancellationReason" name="reason" rows="3" maxlength="1000" required>{{ old('reason') }}</textarea>
            @error('reason')
                <small class="order-cancellation-error">{{ $message }}</small>
            @enderror
            <button type="submit" class="order-cancellation-button">Cancel order</button>
        </form>
    </section>
@endif
