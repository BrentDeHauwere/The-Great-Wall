<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Message;
use App\User;
use App\Wall;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessTweet extends Job implements ShouldQueue
{
	use InteractsWithQueue, SerializesModels;

	protected $tweet;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($tweet)
	{
		$this->tweet = $tweet;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$tweet = json_decode($this->tweet, true);
		$tweet_hashtags = [];

		foreach ($tweet['entities']['hashtags'] as $hashtag)
		{
			array_push($tweet_hashtags, $hashtag['text']);
		}

		$user = User::where('twitter_handle', $tweet['user']['screen_name'])->first();

		if ($user != null)
		{
			$transformedTweet = new Message();
			$transformedTweet->question_id = null;
			$transformedTweet->user_id = $user->id;
			$transformedTweet->channel_id = 2;
			$transformedTweet->text = $tweet['text'];
			$transformedTweet->created_at = new \DateTime();
			$transformedTweet->anonymous = 0;
			$transformedTweet->moderation_level = 0;
			$transformedTweet->count = 0;

			$wall = Wall::whereIn('hashtag', $tweet_hashtags)->first();;

			if ($wall == null)
			{
				print('No walls with hashtag ' . $tweet_hashtags . 'found.');
			}
			else
			{
				$transformedTweet->wall_id = $wall->id;
			}

			$transformedTweet->save();
			print("Tweet from @" . $tweet['user']['screen_name'] . " saved in database." . PHP_EOL);
		}
		else
		{
			print("User " . $tweet['user']['screen_name'] . " was not found in the database, therefore the tweet will not be saved." . PHP_EOL);
		}

	}
}
