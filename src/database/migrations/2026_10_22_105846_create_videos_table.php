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
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mime_type', 64);
            $table->integer('size_in_bytes');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->boolean('loop');
            $table->boolean('muted');
            $table->integer('duration_sec')->nullable();
            $table->string('codec', 64)->nullable();
            $table->foreignUuid('thumbnail_id')->constrained('images', 'image_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
