<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Message;
use App\Poll;
use DB;
use Validator;
use Hash;

class ModeratorController extends Controller
{
	/**
	 * Show an overview of the walls.
	 *
	 * @return Response
	 */
	public function show($id)
	{
    $userid = 1; //getfromloggedinuser
		$messages = Message::with("votes")->where("wall_id", "=", $id)->get();
		$polls = Poll::with("choices.votes")->where("wall_id", "=", $id)->get();

		$result = DB::select(DB::raw("SELECT id,text,moderation_level,created_at,'M' FROM messages UNION SELECT id,question,moderation_level,created_at,'P' FROM polls ORDER BY created_at desc"));


		return View::make('moderator.index')
			->with("messages",$messages)->with("polls",$polls)->with("result",json_decode(json_encode($result),true));
	}
}
