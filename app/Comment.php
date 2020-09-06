<?php

namespace App;

use App\Model;

class Comment extends Model
{
    protected $guarded = [],$with=['user','votes'],$appends=['replyCount'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies() //children
    {
        return $this->hasMany(Comment::class,'comment_id')->whereNotNull('comment_id')->latest();
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class,'comment_id')->whereNull('comment_id');
    }


    public function votes()
    {
        return $this->morphMany(Vote::class,'voteable');

    }

    public function getReplyCountAttribute()
    {
        return $this->replies->count();
    }
}

