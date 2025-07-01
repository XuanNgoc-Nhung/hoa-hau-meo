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
        Schema::table('dien_dan', function (Blueprint $table) {
            $table->timestamp('last_comment')->nullable();
            $table->integer('total_view')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dien_dan', function (Blueprint $table) {
            $table->dropColumn(['last_comment', 'total_view']);
        });
    }
};
