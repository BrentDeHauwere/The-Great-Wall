<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wall extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
