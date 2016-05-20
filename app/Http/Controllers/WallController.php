<?php

namespace App\Http\Controllers;

use App\Helpers\TwitterHelper;
use DB;
use App\Http\Requests;
use App\Http\Requests\ModeratorMessageHandleRequest;
use App\Http\Requests\WallPasswordRequest;
use App\Wall;
use App\Message;
use App\MessageVote;
use App\Poll;
use App\PollChoice;
use App\PollVote;
use App\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request as IllRequest;
use Auth;
use Thujohn\Twitter\Twitter;

class WallController extends Controller
{
	/**
	 * Displays all the available walls
	 *
	 * return view walls.blade.php with walls
	 */
	public function index()
	{
		$walls = DB::table('walls')->select('walls.*', 'users.name as username')->leftJoin('users', 'walls.user_id', '=', 'users.id')
			->where('walls.deleted_at', null)
			->where(function ($query)
			{
				$query->where('open_until', null)
					->orWhere('open_until', '>', date('Y-m-d H:i:s'));
			})
			->orderBy('walls.password')->get();
		$data['walls'] = $walls;

		if (empty($walls))
		{
			$data['info'] = 'No walls available.';
		}

		return view('wall.index')->with($data);
	}


	/**
	 * Display the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		$wall = Wall::findOrFail($id);

		//404 als wall verwijderd is
		if ($wall->deleted_at != null)
		{
			abort(404);
		}

		//als er een einddatum is ingesteld en verstreken --> 404
		if ($wall->open_until != null)
		{
			if ($wall->open_until < date('Y-m-d H:i:s'))
			{
				abort(404);
			}
		}

		if ($wall != null && empty($wall->password))
		{
			//Check for tweets
			//if ($wall->hashtag != null){
			//	TwitterHelper::checkForTweets($wall->hashtag, $id);
			//}

			$posts = $this->getMessagesPollsChronologically($id);
			//$posts = $this->getMessagesPollsSortedOnVotes($id);

			//BEGIN CODE FOR PAGINATION
			//Source: https://laracasts.com/discuss/channels/laravel/laravel-pagination-not-working-with-array-instead-of-collection

			$page = Input::get('page', 1); // Get the current page or default to 1, this is what you miss!
			$perPage = 5;
			$offset = ($page * $perPage) - $perPage;

			$request = new Request();

			$posts = new LengthAwarePaginator(array_slice($posts, $offset, $perPage, true), count($posts), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

			//END CODE FOR Pagination

			return view('wall.show')->with('posts', $posts)->with('wall', $wall);
		}
		else
		{
			return redirect()->action('WallController@index')->with("error", "No password was provided.");
		}
	}

	/**
	 * Handle a wall with Password request
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function enterWallWithPassword(WallPasswordRequest $request)
	{
		$password = $request->input("password");
		$wall_id = $request->input("wall_id");
		$wall = Wall::find($wall_id);

		if ($wall != null && Hash::check($password, $wall->password))
		{
			$messages = Message::with('votes')->where('wall_id', $wall_id)->where('question_id', NULL)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$posts = $this->getMessagesPollsChronologically($messages, $polls);
			return view('wall.show')->with('posts', $posts)->with('wall', $wall);
		}
		else
		{
			return redirect('wall/')->with('error', "Wrong password. Please try again.");
		}
	}

	private function getMessagesPollsChronologically($wall_id)
	{
		$messages = Message::with('votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
		$polls = Poll::with('choices.votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();

		/* Sort messages / poll into a chronologically ordered 2D array */
		$posts = [];

		if (!$messages->isEmpty())
		{
			foreach ($messages as $message)
			{
				array_push($posts, array('m', $message));
			}
		}
		else
		{
			foreach ($polls as $poll)
			{
				array_push($posts, array('p', $poll));
			}
		}

		$pollCounter = 0;
		foreach ($polls as $poll)
		{
			$append = true;
			$counter = 0;
			foreach ($posts as $post)
			{
				if ($poll->created_at > $post[1]->created_at)
				{
					$arr = array('p', $poll);
					array_splice($posts, $counter, 0, array($arr));
					$append = false;
					break;
				}
				$counter += 1;
			}

			if($append)
			{
				array_push($posts, array('p',$poll));
			}

			$pollCounter += 1;
		}
		return $posts;
	}

	private function getMessagesPollsSortedOnVotes($wall_id)
	{
		$messages = Message::with('votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('count', 'desc')->get();
		$polls = Poll::with('choices.votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();

		$posts = [];
		if (!$messages->isEmpty())
		{
			foreach ($messages as $message)
			{
				array_push($posts, array('m', $message));
			}
		}
		else
		{
			foreach ($polls as $poll)
			{
				array_push($posts, array('p', $poll));
			}
		}

		$pollCounter = 0;
		foreach ($polls as $poll)
		{
			$append = true;
			$counter = 0;
			foreach ($posts as $post)
			{
				$pollVotes = 0;

				$pollchoices = PollChoice::where('poll_id',$poll->id);
				foreach($pollchoices as $pollchoice){
					$pollVotes+=$pollchoice->count;
				}

				$postVotes = 0;
				if($post[0]=='m')
				{
					$postVotes = $post[1]->count;
				}
				else
				{
					$pollchoices = PollChoice::where('poll_id',$poll->id);
					foreach($pollchoices as $pollchoice){
						$postVotes+=$pollchoice->count;
					}
				}

				if ($pollVotes > $postVotes)
				{
					$arr = array('p', $poll);
					array_splice($posts, $counter, 0, array($arr));
					$append = false;
					break;
				}
				$counter += 1;
			}

			if($append)
			{
				array_push($posts, array('p',$poll));
			}
			$pollCounter += 1;
		}
		return $posts;
	}

	public function create()
	{
		return view('wall_create');
	}


	/**
	 * src: https://gist.github.com/T3hArco/72b29dfdc2bf48bf8d11ec8c770b24d8
	 * Arnaud Coel
	 * Provides a humanized time string
	 * Based on http://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
	 * @param DateTime $time raw date
	 * @return string humanized time
	 */
	public static function humanTimeDifference($time)
	{
		$time = strtotime($time);

		$elapsed = time() - $time;
		if ($elapsed < 10)
			return "Just now";

		$singular = array(365 * 24 * 60 * 60 => 'year',
						  30 * 24 * 60 * 60  => 'month',
						  24 * 60 * 60       => 'day',
						  60 * 60            => 'hour',
						  60                 => 'minute',
						  1                  => 'second',
		);

		$plural = array('year'   => 'years',
						'month'  => 'months',
						'day'    => 'days',
						'hour'   => 'hours',
						'minute' => 'minutes',
						'second' => 'seconds',
		);

		foreach ($singular as $seconds => $humanized)
		{
			$difference = $elapsed / $seconds;

			if ($difference >= 1)
			{
				$rounded = round($difference);

				return $rounded . ' ' . ($rounded > 1 ? $plural[ $humanized ] : $humanized) . " ago";
			}
		}

		return '';
	}

	public function ajaxMessage($id)
	{
		$wall = Wall::find($id);

		if ($wall != null && empty($wall->password))
		{
			if (session()->has('wall' . $wall->id))
			{
				$messages = Message::with('votes')->where('created_at', session('wall' . $wall->id))->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
				$polls = Poll::with('choices.votes')->where('created_at', session('wall' . $wall->id))->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			}
			else
			{
				$polls = Poll::with('choices.votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
				$messages = Message::with('votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			}

			$posts = $this->getMessagesPollsChronologically($messages, $polls);
			session(['wall' . $wall->id => date("Y-m-d H:i:s")]);

			return view('ajax.messages')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
	}

	public function updateShow(Request $request, $id)
	{
		$wall = Wall::findOrFail($id);

		//404 als wall verwijderd is
		if ($wall->deleted_at != null)
		{
			abort(404);
		}

		//als er een einddatum is ingesteld en verstreken --> 404
		if ($wall->open_until != null)
		{
			if ($wall->open_until < date('Y-m-d H:i:s'))
			{
				abort(404);
			}
		}

		if ($wall != null && empty($wall->password))
		{
			$messages = Message::with('votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();

			$posts = $this->getMessagesPollsChronologically($messages, $polls);

			//BEGIN CODE FOR PAGINATION
			//Source: https://laracasts.com/discuss/channels/laravel/laravel-pagination-not-working-with-array-instead-of-collection
			$page = $request->input('page'); // Get the current page or default to 1, this is what you miss!
			$perPage = 5;
			$offset = ($page * $perPage) - $perPage;

			$request = new Request();

			$posts = new LengthAwarePaginator(array_slice($posts, $offset, $perPage, true), count($posts), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

			//END CODE FOR Pagination
			return view('wall.posts')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
	}
}
