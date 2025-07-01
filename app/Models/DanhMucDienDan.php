<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DanhMucDienDan extends Model
{
    protected $table = 'danh_muc_dien_dan';
    
    protected $fillable = [
        'ten_danh_muc',
        'slug',
        'ghi_chu'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->ten_danh_muc);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('ten_danh_muc')) {
                $model->slug = Str::slug($model->ten_danh_muc);
            }
        });
    }
}
