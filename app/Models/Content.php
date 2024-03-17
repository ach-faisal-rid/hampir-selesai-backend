<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $guarded = [
        'freelancer_id',
        'category_id',
        'platform_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function Platform() {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }
    public function Creator() {
        return $this->belongsTo(Creator::class, 'freelancer_id', 'id');
    }
}
