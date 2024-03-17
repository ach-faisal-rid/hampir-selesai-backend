<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'content';

    protected $guarded = [
        'freelancer_id',
        'category_id',
        'platform_id',
        'id'
    ];

    /**
     * Get the category that owns the content.
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    /**
     * Get the platform that owns the content.
     */
    public function Platform() {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }
}
