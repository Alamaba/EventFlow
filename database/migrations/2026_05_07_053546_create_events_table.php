<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisateur_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['mariage', 'ceremonie', 'conference', 'anniversaire', 'concert', 'autre'])->default('autre');
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->string('venue');
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->unsignedInteger('capacity');
            $table->string('cover_image')->nullable();
            $table->enum('status', ['brouillon', 'publie', 'annule', 'termine'])->default('brouillon');
            $table->boolean('is_paid')->default(false);
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('DJF');
            $table->json('program')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
