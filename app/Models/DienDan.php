<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DienDan extends Model
{
    protected $table = 'dien_dan';
    protected $fillable = ['id','danh_muc_id', 'ten_dien_dan', 'slug','hinh_anh','vi_tri','the_tim_kiem','so_dien_thoai','chi_tiet', 'trang_thai','nguoi_tao', 'muc_gia','last_comment','total_view', 'created_at', 'updated_at'];
    protected $appends = ['total_comment'];
    public function danhMucDienDan()
    {
        return $this->belongsTo(DanhMucDienDan::class, 'danh_muc_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'nguoi_tao');
    }
    public function binhLuans()
    {
        return $this->hasMany(BinhLuan::class, 'post_id');
    }

    /**
     * Lấy tổng số bình luận của diễn đàn
     */
    public function getTotalCommentAttribute()
    {
        return $this->binhLuans()->count();
    }
}
