<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the wall that owns the message.
     */
    public function wall()
    {
        return $this->belongsTo('App\Wall');
    }

    /**
     * Get the votes of the message.
     */
    public function votes()
    {
        return $this->hasMany('App\MessageVote');
    }

    /**
     * Get the channel that owns the message.
     */
    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    /**
     * Get the answers to the message.
     */
    public function answers()
    {
        return $this->hasMany('App\Message', 'question_id', 'id');
    }
}
