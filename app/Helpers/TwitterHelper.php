<?php

namespace App\Helpers;

use App\Wall;
use Thujohn\Twitter\Twitter;
use App\Message;

class TwitterHelper
{
	public static function checkForTweets($hashtag, $wallId)
	{
		$tweets = \Twitter::getSearch(['q'           => '#' . $hashtag,
									   'result_type' => 'recent',
									   'format'      => 'object']);
		TwitterHelper::transformTweets($tweets, $wallId);
	}
	
	private static function transformTweets($tweets, $wallId)
	{
		$transformedTweets = [];

		foreach ($tweets->statuses as $tweet)
		{
			$transformed = new Message();
			$transformed->wall_id = $wallId;
			$transformed->channel_id = 2;
			$transformed->text = $tweet->text;
			$transformed->created_at = $tweet->created_at;
			$transformed->anonymous = 0;
			$transformed->moderator_level = 0;
			$transformed->count = 0;
			dd($transformed);
		}
	}
}