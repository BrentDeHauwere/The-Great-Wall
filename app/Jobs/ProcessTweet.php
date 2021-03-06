<?php

namespace App\Jobs;

use Capi\Clients\GuzzleClient;
use Event;
use App\Events\NewMessageEvent;
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

		//If no hashtags were included in the tweet, do not save tweet
		if (!empty($tweet_hashtags))
		{
			$user = User::where('twitter_handle', $tweet['user']['screen_name'])->first();

			//If no user is found with a corresponding twitter handle, do not save tweet
			if ($user != null)
			{
				$transformedTweet = new Message();
				$transformedTweet->question_id = null;
				$transformedTweet->user_id = $user->id;
				$transformedTweet->channel_id = 2;
				$transformedTweet->text = $tweet['text'];
				$transformedTweet->created_at = new \DateTime();
				$transformedTweet->anonymous = 0;
				$transformedTweet->moderation_level = $user->banned();
				$transformedTweet->count = 0;

				if (!empty($tweet_hashtags))
				{
					$wall = Wall::whereIn('hashtag', $tweet_hashtags)->first();
				}
				else
				{
					$wall = null;
				}


				if ($wall != null)
				{
					$transformedTweet->wall_id = $wall->id;

					if ($transformedTweet->save())
					{
						print("Tweet from @" . $tweet['user']['screen_name'] . " saved in database." . PHP_EOL);
						print("Text: " . $tweet['text'] . PHP_EOL);
						Event::fire(new NewMessageEvent($transformedTweet));
					}
					else
					{
						print("Could not save tweet from @" . $tweet['user']['screen_name'] . " in the database." . PHP_EOL);
					}
				}
				else
				{
					print('No corresponding walls found.');
				}
			}
			else
			{
				print("User " . $tweet['user']['screen_name'] . " was not found in the database, therefore the tweet will not be saved." . PHP_EOL);
			}
		}
		else
		{
			print("No hashtags were found in the tweet. Maybe there are no walls with hashtags defined?");
		}

		print(PHP_EOL);
	}

	/**
	 * Handle a job failure.
	 *
	 * @return void
	 */
	public function failed()
	{
		print("Failed to insert tweet from " . $this->tweet['user']['screen_name'] ."in database...");
	}
}
