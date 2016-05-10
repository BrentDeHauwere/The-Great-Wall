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
use Validator;
use Hash;
use DB;

class SessionController extends Controller
{
	/**
	 * Show an overview of the walls.
	 *
	 * @return Response
	 */
	public function index()
	{
		$walls = Wall::where('open_until','>',date('Y-m-d H:i:s'))->orWhere('open_until', null)->orderBy('name')->get();

		foreach($walls as $wall){
			if (!empty($wall->password)){
				$wall->password = "Yes";
			}
		}

		return View::make('sessions.index')
			->with('walls', $walls);
	}

	/**
	 * Show the form for creating a new wall.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}

	/**
	 * Store a newly created wall in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id' 	=> 'required|numeric|min:1|exists:users',
			'name'    	=> 'required',
			'password'	=> 'confirmed',
			'open_until' => 'date_format:Y-m-d H:i:s',
		]);

		$wall = new Wall;
		$wall->user_id = $request->input('user_id');
		$wall->name = $request->input('name');
		if ($request->has('password'))
		{
			$wall->password = Hash::make($request->input('password'));
		}
		$wall->open_until = $request->input('open_until');
		$wall->save();

		Session::flash('info', 'Successfully created wall.');

		return Redirect::to('sessions');
	}


	/**
	 * Display the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		$userid = 1; //getfromloggedinuser
		$messages = Message::with("votes")->where("wall_id", "=", $id)->get();
		$polls = Poll::with("choices.votes")->where("wall_id", "=", $id)->get();

		$result = DB::select(DB::raw("SELECT id,text,moderation_level,created_at,'M' FROM messages UNION SELECT id,question,moderation_level,created_at,'P' FROM polls ORDER BY created_at desc"));

		return View::make('sessions.show')
			->with("messages",$messages)->with("polls",$polls)->with("result",json_decode(json_encode($result),true));
	}

	/**
	 * Show the form for editing the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function edit($id)
	{
		$wall = Wall::find($id);

		return View::make('sessions.edit')
			->with('wall', $wall)->with('success','Something');
	}

	/**
	 * Update the specified wall in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function update(Request $request, $id)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id' 	=> 'required|numeric|min:1|exists:users',
			'name'    	=> 'required',
			'password'	=> 'confirmed',
			'open_until' => 'date_format:Y-m-d H:i:s',
		]);

		$wall = Wall::find($id);
		$wall->user_id = $request->input('user_id');
		$wall->name = $request->input('name');
		if ($request->has('password'))
		{
			$wall->password = Hash::make($request->input('password'));
		}
		else
		{
			$wall->password = null;
		}
		$wall->open_until = $request->input('open_until');
		$wall->save();

		Session::flash('info', 'Successfully updated wall.');

		return Redirect::to('sessions');
	}

	/**
	 * Remove (inactive) the specified wall from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function destroy($id)
	{
		$wall = Wall::find($id);
		$wall->delete();

		Session::flash('info', 'Successfully deleted the wall.');

		return Redirect::to('sessions');
	}
}
