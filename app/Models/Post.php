<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'contentHTML',
        'contentText',
        'category',
        'thumbnail',
        'author',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category");
    }
}
