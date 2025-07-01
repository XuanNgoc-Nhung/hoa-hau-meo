<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    protected $table = 'hinh_anh';
    protected $fillable = ['id', 'user_id', 'path', 'created_at', 'updated_at'];
}
