<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('DJF');
            $table->enum('payment_method', ['stripe', 'mobile_money', 'paypal', 'especes'])->default('stripe');
            $table->string('stripe_payment_intent')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['en_attente', 'paye', 'rembourse', 'echoue'])->default('en_attente');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
