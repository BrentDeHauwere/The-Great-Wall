<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TwitterStream;
use DB;

class ConnectToStreamingAPI extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'connect_to_streaming_api';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Connect to the Twitter Streaming API';

	protected $twitterStream;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(TwitterStream $twitterStream)
	{
		$this->twitterStream = $twitterStream;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$twitter_consumer_key = env('TWITTER_CONSUMER_KEY', '');
		$twitter_consumer_secret = env('TWITTER_CONSUMER_SECRET', '');

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

		$this->twitterStream->consumerKey = $twitter_consumer_key;
		$this->twitterStream->consumerSecret = $twitter_consumer_secret;
		$this->twitterStream->setTrack($hashtags);
		$this->twitterStream->consume();
	}
}
