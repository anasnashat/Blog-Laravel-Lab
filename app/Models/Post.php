<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use softDeletes;
    protected $fillable = ['title', 'slug', 'description', 'user_id'];

//    public function getRouteKey()
//    {
//        return $this->slug;
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
