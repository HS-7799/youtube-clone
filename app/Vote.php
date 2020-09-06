<?php

namespace App;

use App\Model;

class Vote extends Model
{

    protected $fillable = ['user_id','type'];

    public function voteable()
    {
        return $this->morphTo();
    }
}
