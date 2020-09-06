<?php

namespace App;

use App\Model;


class Channel extends Model
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return  $value ? "/storage/$value" : '/images/noImage.png';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }



}
