<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageVote extends Model
{
    /**
     * Get the message that owns the vote.
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}