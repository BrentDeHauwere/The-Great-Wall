<?php

namespace App\Helpers;

use App\Wall;
use Thujohn\Twitter\Twitter;

class TwitterHelper
{
	public static function checkForTweets(Wall $wall)
	{
		$tweets = Twitter::getSearch(['q'           => '#' . $wall->hashtag,
									  'result_type' => 'recent',
									  'format'      => 'array']);
		dd($tweets);
		transformTweets($tweets);
	}
	
	private function transformResponse($tweets)
	{
		$transformedTweets = [];
	}
}