<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\This;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'slug', 'description', 'image', 'user_id'];

//    public function getRouteKey()
//    {
//        return $this->slug;
//    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true
            ]
        ];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


}
