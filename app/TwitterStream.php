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

		$this->setTrack($hashtags);
	}
}