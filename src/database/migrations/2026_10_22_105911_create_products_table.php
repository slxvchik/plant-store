<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('active');
            $table->integer('sort');
            $table->string('name', 255);
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('active');
            $table->string('sku', 100);
            $table->integer('sort');
            $table->text('description');
            $table->integer('price');
            $table->string('form_factor', 512);
            $table->string('size', 512);
            $table->integer('age_in_months');
            $table->date('sowing_date');
            $table->timestamps();
        });

        Schema::create('offer_stocks', function (Blueprint $table) {
            $table->foreignUuid('offer_id')->constrained();
            $table->foreignUuid('warehouse_id')->constrained();
            $table->integer('quantity');
            $table->integer('reserved');
            $table->primary(['offer_id', 'warehouse_id']);
        });

        Schema::create('offer_images', function (Blueprint $table) {
            $table->foreignUuid('offer_id')->constrained();
            $table->foreignUuid('image_id')->constrained();
            $table->primary(['offer_id', 'image_id']);
        });

        Schema::create('offer_videos', function (Blueprint $table) {
            $table->foreignUuid('offer_id')->constrained();
            $table->foreignUuid('video_id')->constrained();
            $table->primary(['offer_id', 'video_id']);
        });

        Schema::create('product_offers', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('offer_id')->constrained();
            $table->primary(['product_id', 'offer_id']);
        });

        Schema::create('product_tags', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('tag_id')->constrained();
            $table->primary(['product_id', 'tag_id']);
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('category_id')->constrained();
            $table->primary(['product_id', 'category_id']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('image_id')->constrained();
            $table->integer('sort');
            $table->primary(['product_id', 'image_id']);
        });

        Schema::create('product_videos', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('video_id')->constrained();
            $table->integer('sort');
            $table->primary(['product_id', 'video_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_videos');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_offers');
        Schema::dropIfExists('offer_videos');
        Schema::dropIfExists('offer_images');
        Schema::dropIfExists('offer_stocks');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('products');
    }
};
