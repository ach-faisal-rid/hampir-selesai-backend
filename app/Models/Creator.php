<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;

    protected $guarded = [
        'users_id',
        'category_id',
        'platform_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function Platform() {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }
    public function User() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
