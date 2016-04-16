<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
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
}
