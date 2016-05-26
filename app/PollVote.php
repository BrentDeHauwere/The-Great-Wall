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

    /**
     * checks if other poll vote is the same
     */
    public function equals(PollVote $pv)
    {
        if($pv->poll_choice_id==$this->poll_choice_id && $pv->user_id==$this->user_id)
        {
            return true;
        }
        return false;
    }
}
