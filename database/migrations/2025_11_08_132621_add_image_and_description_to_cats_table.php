<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cats', function (Blueprint $table) {
            if (!Schema::hasColumn('cats', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('cats', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cats', function (Blueprint $table) {
            if (Schema::hasColumn('cats', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('cats', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};