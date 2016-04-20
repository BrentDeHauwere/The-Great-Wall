<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    public $timestamps = false;
    /**
     * Get the choice that owns the vote.
     */
    public function choice()
    {
        return $this->belongsTo('App\PollChoice');
    }
}
