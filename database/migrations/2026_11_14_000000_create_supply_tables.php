<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone', 32)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('product_unit_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('product_supplies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('offer_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('declared_quantity');
            $table->unsignedInteger('actual_quantity');
            $table->unsignedInteger('unit_purchase_price_in_kopecks')->nullable();
            $table->unsignedInteger('total_purchase_price_in_kopecks')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('mis_graded')->default(false);
            $table->timestamps();
        });

        Schema::create('product_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_supply_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('offer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('warehouse_id')->constrained()->restrictOnDelete();
            $table->boolean('reserved')->default(false);
            $table->date('sowing_date')->nullable();
            $table->foreignUuid('product_unit_status_id')->constrained()->restrictOnDelete();
            $table->text('comments')->default('');
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_units');
        Schema::dropIfExists('product_supplies');
        Schema::dropIfExists('product_unit_statuses');
        Schema::dropIfExists('suppliers');
    }
};
