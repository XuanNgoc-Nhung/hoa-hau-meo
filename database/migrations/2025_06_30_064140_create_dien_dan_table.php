<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dien_dan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danh_muc_id')->nullable();
            $table->string('ten_dien_dan')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->string('vi_tri')->nullable();
            $table->string('the_tim_kiem')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->text('chi_tiet')->nullable();
            $table->string('trang_thai')->nullable();
            $table->string('nguoi_tao')->nullable();
            $table->decimal('muc_gia', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dien_dan');
    }
}; 