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
  * return view wall.index.blade.php with walls
  */
  public function index(){
    $walls = Wall::all();
    return view('wall.index', compact('walls'));
  }

	/**
	 * Display the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function show($id)
	{
		$wall = Wall::find($id);
		if(empty($wall->password)){
			$messages = Message::with('votes')->where('wall_id', '=', $id)->get();
			$polls = Poll::with('choices.votes')->where('wall_id', '=', $id)->get();

			//$result = DB::select(DB::raw("SELECT id,created_at,'M' FROM messages UNION SELECT id,created_at,'P' FROM polls ORDER BY created_at"));
			return view('wall.show')->with('messages', $messages)->with('polls', $polls);//->with('result',$result);
		}
		else{
			redirect()->back()->with("danger","No password was provided");
		}
	}


	/**
	 * Handle a wall with Password request
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function enterWallWithPassword(WallPasswordRequest $request){
		$password = $request->input("password");
		$wall_id = $request->input("wall_id");
		$wall = Wall::find($wall_id);

		if(Hash::check($password, $wall->password)){
			$messages = Message::with('votes')->where('wall_id', '=', $wall_id)->get();
			$polls = Poll::with('choices.votes')->where('wall_id', '=', $wall_id)->get();
			return view("wall.show")->with('messages', $messages)->with('polls', $polls);
		}
		else{
			return redirect('wall/')->with('danger', "Wrong password. Please try again.");
		}
	}

	public function create(){
		return view('wall_create');
	}

}
