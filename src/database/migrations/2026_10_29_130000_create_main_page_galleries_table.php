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
        Schema::create('main_page_galleries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('sort');
            $table->foreignUuid('image_id')->constrained();
            $table->string('pre_title', 256)->nullable();
            $table->string('title', 256)->nullable();
            $table->text('description')->nullable();
            $table->string('button_link', 512)->nullable();
            $table->string('button_text', 256)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_page_galleries');
    }
};
