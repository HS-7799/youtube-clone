<?php

namespace App;

use App\Model;

class Video extends Model
{
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'voteable');

    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('comment_id')->latest();
    }

    public function getThumbnailAttribute($value)
    {
        return '/storage/'.$value;
    }
}
