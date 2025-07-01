<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binh_luan';
    protected $fillable = ['post_id', 'user_id', 'content'];

    public function dienDan()
    {
        return $this->belongsTo(DienDan::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
