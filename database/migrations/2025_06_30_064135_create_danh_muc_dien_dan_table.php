<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_muc_dien_dan', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc')->nullable();
            $table->string('slug')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_muc_dien_dan');
    }
}; 