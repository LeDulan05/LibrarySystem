<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            // pending = waiting in queue, fulfilled = copy ready, hold running,
            // closed = converted into a loan, cancelled = hold expired
            $table->enum('status', ['pending', 'fulfilled', 'closed', 'cancelled'])->default('pending');
            $table->date('reservation_date');
            $table->date('hold_expires_at')->nullable();
            $table->unsignedInteger('queue_position')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
