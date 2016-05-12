<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollChoice extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the votes for the choice.
     */
    public function votes()
    {
        return $this->hasMany('App\PollVote');
    }

    /**
     * Get the poll that owns the choice.
     */
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    /**
     * Get the user that owns the choice.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
