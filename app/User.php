<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Get the votes on polls for this user.
     */
    public function pollVotes()
    {
        return $this->hasMany('App\PollVote');
    }

    /**
     * Get the votes on messages for this user.
     */
    public function messageVotes()
    {
        return $this->hasMany('App\MessageVote');
    }

    /**
     * Get the whether this user is on the blacklist or not.
     */
    public function banned()
    {
        return Blacklist::where('user_id', $this->id)->first()->exists();
    }
}
