<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageVote extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Get the message that owns the vote.
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
