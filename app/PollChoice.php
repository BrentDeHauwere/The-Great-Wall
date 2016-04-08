<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollChoice extends Model
{
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
}
