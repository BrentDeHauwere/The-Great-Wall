<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Get the messages of the channel.
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
