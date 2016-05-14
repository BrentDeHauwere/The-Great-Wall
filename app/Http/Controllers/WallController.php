<?php

namespace App\Http\Controllers;

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
			->get();

		if (empty($walls))
		{
			return view('wall.index')->with('walls', $walls)->with('info', 'No walls available.');
		}
		else
		{
			return view('wall.index')->with('walls', $walls);
		}
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
			if ($wall->open_unitl > date('d-m-y H:i:s'))
			{
				abort(404);
			}
		}

		if ($wall != null && empty($wall->password))
		{
			$messages = Message::with('votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();

			$posts = $this->sortMessagesPolls($messages, $polls);

			//BEGIN CODE FOR PAGINATION
			//Source: https://laracasts.com/discuss/channels/laravel/laravel-pagination-not-working-with-array-instead-of-collection
			$page = Input::get('page', 1); // Get the current page or default to 1, this is what you miss!
			$perPage = 5;
			$offset = ($page * $perPage) - $perPage;

			$request = new Request();

			$posts = new LengthAwarePaginator(array_slice($posts, $offset, $perPage, true), count($posts), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

			//END CODE FOR Pagination

			// user that's logged in.
			$loggedInUser = 2;

			$user = User::with('pollVotes', 'messageVotes')->where('id', $loggedInUser)->first();

			return view('wall.show')->with('posts', $posts)->with('wall', $wall)->with('user', $user);
		}
		else
		{
			redirect()->back()->with("error", "No password was provided.");
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
			$messages = Message::with('votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$posts = $this->sortMessagesPolls($messages, $polls);

			return view('wall.show')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
		else
		{
			return redirect('wall/')->with('error', "Wrong password. Please try again.");
		}
	}

	private function sortMessagesPolls($messages, $polls)
	{
		/* Sort messages / poll into a chronologically ordered 2D array */
		$posts = [];

		if (!$polls->isEmpty())
		{
			foreach ($polls as $poll)
			{
				array_push($posts, array('p', $poll, $poll->user()->first()));
			}
		}
		else
		{
			foreach ($messages as $message)
			{
				array_push($posts, array('m', $message, $message->user()->first()));
			}
		}

		$msgCounter = 0;

		if ($messages != null)
		{
			foreach ($messages->where('question_id', NULL) as $message)
			{
				$counter = 0;

				if ($polls->isEmpty())
				{
					break;
				}

				foreach ($posts as $post)
				{
					if ($message->created_at > $post[1]->created_at)
					{
						$arr = array('m', $message, $message->user()->first());
						array_splice($posts, $counter, 0, array($arr));
						unset($messages[ $msgCounter ]);
						break;
					}
					elseif ($message->create_at < $post[1]->created_at)
					{
						array_push($posts, array('m', $message, $message->user()->first()));
						unset($messages[ $msgCounter ]);
						break;
					}
					$counter += 1;
				}
				$msgCounter += 1;
			}
		}

		return $posts;
	}

	public
	function create()
	{
		return view('wall_create');
	}


	/**
	 * src: https://gist.github.com/T3hArco/72b29dfdc2bf48bf8d11ec8c770b24d8
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
			return "just now";

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

			$posts = $this->sortMessagesPolls($messages, $polls);
			session(['wall' . $wall->id => date("Y-m-d H:i:s")]);

			return view('ajax.messages')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
	}

	public function updateShow(Request $request, $id)
	{
		$wall = Wall::findOrFail($id);
		if ($wall->deleted_at != null || $wall->open_until == 0 || $wall->open_until < date('d-m-y H:i:s'))
		{
			abort(404);
		}

		if ($wall != null && empty($wall->password))
		{
			$messages = Message::with('votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();

			$posts = $this->sortMessagesPolls($messages, $polls);

			//BEGIN CODE FOR PAGINATION
			//Source: https://laracasts.com/discuss/channels/laravel/laravel-pagination-not-working-with-array-instead-of-collection
			$page = $request->input('page'); // Get the current page or default to 1, this is what you miss!
			$perPage = 5;
			$offset = ($page * $perPage) - $perPage;

			$request = new Request();

			$posts = new LengthAwarePaginator(array_slice($posts, $offset, $perPage, true), count($posts), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);

			//END CODE FOR Pagination
			return view('wall.updateshow')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
	}
}
