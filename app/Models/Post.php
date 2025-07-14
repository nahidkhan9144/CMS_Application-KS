<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'status',
        'published_date',
        'author_id',
    ];

     protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->summary)) {
                $post->summary = Str::limit(strip_tags($post->content), 150);
            }
        });
    }

}
