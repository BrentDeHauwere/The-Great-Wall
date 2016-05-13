<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the user that owns the blacklist record.
	 */
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
