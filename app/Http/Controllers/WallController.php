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
use Illuminate\Http\Request;
use Hash;

class WallController extends Controller
{

	/**
	 * Displays all the available walls
	 *
	 * return view walls.blade.php with walls
	 */

	public function index()
	{
		$walls = DB::table('walls')->select('walls.*', 'users.name as username')->leftJoin('users', 'walls.user_id', '=', 'users.id')->where('walls.deleted_at', null)->Where('open_until', 0)->orWhere('open_until','>',date('Y-m-d H:i:s'))->get();
		return view('wall.index')->with('walls', $walls);
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
		if ($wall->deleted_at != null || $wall->open_until == 0 || $wall->open_until < date('d-m-y H:i:s')) {
			abort(404);
		}

		if ($wall!=null && empty( $wall->password ) )
		{
			$messages = Message::with('votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$posts = $this->sortMessagesPolls($messages, $polls);

			return view('wall.show')->with('posts', $posts)->with('wall', $wall);
		}
		else
		{
			redirect()->back()->with("error", "No password was provided");
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

		if ( $wall!=null && Hash::check($password, $wall->password) )
		{
			$messages = Message::with('votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$polls = Poll::with('choices.votes')->where('wall_id', $wall_id)->where('moderation_level', 0)->orderBy('created_at', 'desc')->get();
			$posts = $this->sortMessagesPolls($messages, $polls);

			return view('wall.show')->with('posts', $posts)->with('wall', $wall);//->with('result',$result);
		}
		else
		{
			return redirect('wall/')->with('danger', "Wrong password. Please try again.");
		}
	}

	private function sortMessagesPolls($messages, $polls)
	{
		/* Sort messages / poll into a chronologically ordered 2D array */
		$posts = [ ];

		foreach ($polls as $poll)
		{
			array_push($posts, array( 'p', $poll ));
		}

		$msgCounter = 0;
		foreach ($messages->where('question_id', NULL) as $message)
		{
			$counter = 0;
			foreach ($posts as $post)
			{
				if ( $message->created_at > $post[1]->created_at )
				{
					$arr = array( 'm', $message );
					array_splice($posts, $counter, 0, array( $arr ));
					unset( $messages[ $msgCounter ] );
					break;
				}
				elseif ( $message->create_at < $posts[0][1]->created_at )
				{
					array_push($posts, array( 'm', $message ));
					unset( $messages[ $msgCounter ] );
					break;
				}
				$counter += 1;
			}
			$msgCounter += 1;
		}

		return $posts;
	}

	public function create()
	{
		return view('wall_create');
	}

}
