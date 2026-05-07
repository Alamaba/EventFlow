<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'organisateur', 'agent', 'invite'])->default('invite')->after('email');
            $table->string('phone', 20)->nullable()->after('role');
            $table->string('avatar')->nullable()->after('phone');
            $table->foreignId('organisateur_id')->nullable()->constrained('users')->nullOnDelete()->after('avatar');
            $table->boolean('is_active')->default(true)->after('organisateur_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organisateur_id']);
            $table->dropColumn(['role', 'phone', 'avatar', 'organisateur_id', 'is_active']);
        });
    }
};
