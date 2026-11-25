<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('sku', 80)->nullable()->unique();
        });

        DB::table('products')->whereNull('sku')->orderBy('id')->get(['id'])->each(function ($product): void {
            $base = 'JPL-'.str_pad((string) $product->id, 6, '0', STR_PAD_LEFT);
            $sku = $base;
            $suffix = 2;

            while (DB::table('products')->where('sku', $sku)->exists()) {
                $sku = $base.'-'.$suffix++;
            }

            DB::table('products')->where('id', $product->id)->update(['sku' => $sku]);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 40)->unique();
            $table->string('tracking_token_hash', 64)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name', 120);
            $table->string('customer_email', 150);
            $table->string('customer_phone', 30);
            $table->string('shipping_address_line_1');
            $table->string('shipping_address_line_2')->nullable();
            $table->string('shipping_city', 100);
            $table->string('shipping_state', 100);
            $table->string('shipping_postal_code', 20);
            $table->text('customer_note')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method', 30)->default('cash_on_delivery');
            $table->string('payment_status', 30)->default('pending')->index();
            $table->timestamp('cod_collected_at')->nullable();
            $table->foreignId('cod_collected_by')->nullable()->constrained('admin_users')->nullOnDelete();
            $table->string('status', 30)->default('pending')->index();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku', 80);
            $table->string('product_name', 150);
            $table->unsignedSmallInteger('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });

        Schema::create('order_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('status', 40);
            $table->string('title', 120);
            $table->text('notes')->nullable();
            $table->string('actor', 100)->default('System');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_events');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn('sku');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
