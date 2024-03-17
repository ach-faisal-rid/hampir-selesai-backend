<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platform';

    protected $guarded  = [
        'id'
    ];

    public function Content() {
        return $this->hasMany(Content::class, 'platform_id', 'id');
    }
}
