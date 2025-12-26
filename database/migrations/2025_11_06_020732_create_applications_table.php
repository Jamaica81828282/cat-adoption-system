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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cat_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable(); // optional notes from user
            $table->string('payment_method')->nullable(); // gcash, paymaya, bank_transfer, cash
            $table->string('payment_reference')->nullable(); // ADDED THIS LINE - reference number for payment
            $table->decimal('fee', 8, 2)->default(25); // adoption fee
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};