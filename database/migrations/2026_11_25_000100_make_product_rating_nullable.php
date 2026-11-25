<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->nullable()->default(null)->change();
        });

        DB::table('products')->where('rating', 0)->update(['rating' => null]);
    }

    public function down(): void
    {
        DB::table('products')->whereNull('rating')->update(['rating' => 0]);

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(0)->nullable(false)->change();
        });
    }
};
