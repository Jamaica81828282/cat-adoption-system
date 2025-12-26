<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cats', function (Blueprint $table) {
            if (!Schema::hasColumn('cats', 'available')) {
                $table->boolean('available')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('cats', function (Blueprint $table) {
            if (Schema::hasColumn('cats', 'available')) {
                $table->dropColumn('available');
            }
        });
    }
};
