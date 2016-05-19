<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the wall that owns the poll.
     */
    public function wall()
    {
        return $this->belongsTo('App\Wall');
    }

    /**
     * Get the choices of the poll.
     */
    public function choices()
    {
        return $this->hasMany('App\PollChoice');
    }

    /**
     * Get the user that owns the poll.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Get the amount of votes on this poll
     */
    public function numberOfVotes()
    {
        $nmbr = 0;
        foreach($this->choices as $choice)
        {
            $nmbr+=$choice->count;
        }
        return $nmbr;
    }
}
