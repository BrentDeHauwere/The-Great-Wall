<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Get the messages of the wall.
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * Get the polls of the wall.
     */
    public function polls()
    {
        return $this->hasMany('App\Poll');
    }
}
