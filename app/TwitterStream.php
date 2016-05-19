<?php

namespace App;

use OauthPhirehose;
use App\Jobs\ProcessTweet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use DB;


class TwitterStream extends OauthPhirehose
{
	use DispatchesJobs;

	/*
	 * Enqueue each status
	 *
	 * @param string $status
	 */
	public function enqueueStatus($status)
	{
		$this->dispatch(new ProcessTweet($status));
	}

	public function checkFilterPredicates()
	{
		$DBhashtags = DB::table('walls')->select('hashtag')->whereNotNull('hashtag')->get();
		$hashtags = [];

		foreach ($DBhashtags as $hashtag)
		{
			array_push($hashtags, "#" . $hashtag->hashtag);
		}

		//If there are no hashtags in the database, track our Test Account. This will ensure that we have an open connection to Twitter when we have no hashtags
		if (empty($hashtags))
		{
			$hashtags = ['@EhbTheGreatWall'];
		}

		$this->setTrack($hashtags);
	}
}