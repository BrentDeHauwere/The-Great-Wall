<?php

namespace App\Http\Controllers;

use App\User;
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
use Auth;
use App\Blacklist;

class SessionController extends Controller
{
	/**
	 * Show an overview of the walls.
	 *
	 * @return Response
	 */
	public function index()
	{
		$walls = Wall::withTrashed()->with('user')->orderBy('name')->get();

		foreach ($walls as $wall)
		{
			if (!empty($wall->password))
			{
				$wall->password = "Yes";
			}
			else
			{
				$wall->password = "No";
			}

			if ($wall->deleted_at != null)
			{
				$wall->open_until = 'Manually closed';
			}
			else if ($wall->open_until == null)
			{
				$wall->open_until = 'Infinity (not set)';
			}
			else if ($wall->open_until < date('Y-m-d H:i:s'))
			{
				$wall->open_until = "Automatically closed ({$wall->open_until})";
			}
		}

		if (empty($walls))
		{
			return View::make('session.index')->with('walls', $walls)->with('info', 'No sessions available.');
		}
		else
		{
			return View::make('session.index')->with('walls', $walls);
		}
	}

	/**
	 * Show the form for creating a new wall.
	 *
	 * @return Response
	 */
	public function create()
	{
		$speakers = User::where('role', 'Speaker')->get();
		return View::make('session.create')->withSpeakers($speakers);
	}

	/**
	 * Store a newly created wall in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Server-side validation
		$validator = Validator::make($request->all(), [
			'name'       => 'required',
			'speaker'    => 'required|exists:users,id,role,Speaker',
			'image'    	 => 'image',
			'password'   => 'confirmed',
			'open_until' => 'date',
		]);

		if ($request->input('password') != null && $request->input('hashtag') != null)
		{
			$validator->after(function($validator) {
					$validator->errors()->add('hashtag', 'You can only add a hashtag if the session is not password protected.');
			});
		}

		if ($validator->fails())
		{
			return redirect('session/create')
				->withErrors($validator)
				->withInput();
		}

		$wall = new Wall;
		$wall->user_id = $request->input('speaker');
		$wall->name = $request->input('name');
		$wall->description = $request->input('description');
		$wall->hashtag = $request->input('hashtag');

		if ($request->hasFile('image'))
		{
			// We need the wall_id
			$wall->save();

			$destinationPath = storage_path() . '/app/wall_images/';
			$fileName = $wall->id . '.' . $request->file('image')->getClientOriginalExtension();
			$request->file('image')->move($destinationPath, $fileName);
		}

		if ($request->has('password'))
		{
			$wall->password = Hash::make($request->input('password'));
		}

		if ($request->input('open_until') == null)
		{
			$wall->open_until = null;
		}
		else
		{
			$wall->open_until = $request->input('open_until');
		}

		$wall->created_at = new \DateTime();

		$wall->save();

		Session::flash('success', 'Successfully created session.');

		return Redirect::to('session');
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
		$wall = Wall::findOrFail($id);
		$messages = Message::with("votes", "user")->where("wall_id", "=", $id)->get();
		$polls = Poll::with("choices.votes", "user")->where("wall_id", "=", $id)->get();
		$blacklistedUserIDs = Blacklist::all('user_id')->toArray();

		$result = DB::select(DB::raw("SELECT id,user_id,text,moderation_level,created_at,'M' FROM messages WHERE wall_id = {$id} UNION SELECT id,user_id,question,moderation_level,created_at,'P' FROM polls WHERE wall_id = {$id} ORDER BY created_at desc"));

		if (count($result) == 0)
		{
			return View::make('session.show')
				->with('wall', $wall)
				->with("messages", $messages)
				->with("polls", $polls)
				->with("result", json_decode(json_encode($result), true))
				->with("blacklistedUserIDs", $blacklistedUserIDs)
				->with('info', 'No messages or polls available on this session');
		}

		return View::make('session.show')
			->with('wall', $wall)
			->with("messages", $messages)
			->with("polls", $polls)
			->with("blacklistedUserIDs", $blacklistedUserIDs)
			->with("result", json_decode(json_encode($result), true));
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

		// Required for datetime-local inputfield
		if ($wall->open_until != null)
		{
			$old_date_timestamp = strtotime($wall->open_until);
			$wall->open_until = date('Y-m-d H:i', $old_date_timestamp);
			$wall->open_until = str_replace(' ', 'T', $wall->open_until);
		}

		$speakers = User::where('role', 'Speaker')->get();

		return View::make('session.edit')
			->with('wall', $wall)
			->withSpeakers($speakers);;
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
			'name'       => 'required',
			'speaker'    => 'required|exists:users,id,role,Speaker',
			'password'   => 'confirmed',
			'open_until' => 'date',
		]);

		$wall = Wall::find($id);
		$wall->user_id = $request->input('speaker');
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

		Session::flash('success', 'Successfully updated session.');

		return Redirect::to('session');
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

		Session::flash('success', 'Successfully closed the session.');

		return Redirect::to('session');
	}

	/**
	 * Add (active) the specified wall to storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function revertDestroy($id)
	{
		$wall = Wall::onlyTrashed()->find($id);
		$wall->restore();

		Session::flash('success', 'Successfully opened the session.');

		return Redirect::to('session');
	}
}
