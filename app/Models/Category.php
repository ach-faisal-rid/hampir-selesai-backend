<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded  = [
        'id'
    ];

    public function Content() {
        return $this->hasMany(Content::class, 'category_id', 'id');
    }
    public function Creator() {
        return $this->hasMany(Creator::class, 'category_id', 'id');
    }
}
