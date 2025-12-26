<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Add payment_method if it doesn't exist
            if (!Schema::hasColumn('applications', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            
            // Add payment_reference if it doesn't exist
            if (!Schema::hasColumn('applications', 'payment_reference')) {
                $table->string('payment_reference')->nullable();
            }
            
            // Add fee if it doesn't exist
            if (!Schema::hasColumn('applications', 'fee')) {
                $table->decimal('fee', 8, 2)->default(25);
            }
            
            // Add payment_status if it doesn't exist
            if (!Schema::hasColumn('applications', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $columns = ['payment_method', 'payment_reference', 'fee', 'payment_status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('applications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};