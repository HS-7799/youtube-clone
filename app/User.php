<?php

namespace App;

use App\Channel;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = (string)Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function channel() // user channel
    {
        return $this->hasOne(Channel::class);
    }

    public function channels() // user subscribed to channels
    {
        return $this->belongsToMany(Channel::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }




    public function subscribe(Channel $channel)
    {
        $this->channels()->save($channel);
    }

    public function unSubscribe(Channel $channel)
    {
        $this->channels()->detach($channel);
    }

    public function toggleSubscription(Channel $channel)
    {
        $this->channels()->toggle($channel);
    }

    public function isSubscribed(Channel $channel)
    {
        return $this->channels->contains($channel);
    }
}
