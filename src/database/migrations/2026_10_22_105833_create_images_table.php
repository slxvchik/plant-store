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
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('web_path_to_file', 128);
            $table->string('mime_type', 64);
            $table->integer('size_in_bytes');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('title_text', 256)->nullable();
            $table->string('alt_text', 256)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
