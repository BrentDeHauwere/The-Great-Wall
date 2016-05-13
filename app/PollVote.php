<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the choice that owns the vote.
     */
    public function choice()
    {
        return $this->belongsTo('App\PollChoice','poll_choice_id','id');
    }

    /**
     * Get the user that owns the vote.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
