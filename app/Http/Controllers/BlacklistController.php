<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Http\Requests;
use App\Blacklist;
use App\User;
use DB;
use DateTime;

class BlacklistController extends Controller
{
	/**
	 * Show an overview of the blacklisted users.
	 *
	 * @return Response
	 */
	public function index()
	{
		$blacklistedUsers = Blacklist::with('user')->get();

		if ($blacklistedUsers->isEmpty())
		{
			return view('blacklist.index')->with('blacklistedUsers', $blacklistedUsers)->with('info', 'No blacklisted users.');
		}
		else
		{
			return view('blacklist.index')->with('blacklistedUsers', $blacklistedUsers);
		}
	}

	/**
	 * Show the form for blacklisting a user.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{

		//The request gets oftewel a message_id or a poll_id, depending on the button which was pressed
		$message_id = $request->input('message_id');
		$poll_id = $request->input('poll_id');

		if (!empty($message_id))
		{
			$user_id = DB::table('messages')->select('user_id')->where('id', $request->input('message_id'))->first();
		}
		elseif (!empty($poll_id))
		{
			$user_id = DB::table('polls')->select('user_id')->where('id', $request->input('poll_id'))->first();
		}
		else
		{
			abort(422);
		}

		//Check if user isn't already banned
		if (Blacklist::find($user_id->user_id) != null){
			return redirect()->back()->with('error', 'User was already blacklisted.');
		}

		$username = DB::table('users')->select('name')->where('id', $user_id->user_id)->first();
		$username = $username->name;

		//$user_id is a stdClass class for some reason...
		return view('blacklist.create')->with('user_id', $user_id->user_id)->with('message_id', $message_id)->with('poll_id', $poll_id)->with('username', $username);
	}

	/**
	 * Store a user in the blacklist.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id'    => 'required|numeric|min:1',
			'reason'     => 'required',
			'message_id' => 'numeric|min:1',
			'poll_id'    => 'numeric|min:1',
		]);

		//Create entry in the database
		$db = DB::table('blacklists')->insert(['user_id' => $request->input('user_id'), 'reason' => $request->input('reason'), 'created_at' => new DateTime()]);

		//Update the users messages or polls in the tables
		if (!empty($request->input('message_id')))
		{
			$update = DB::table('messages')->where('id', $request->input('message_id'))->update(['moderation_level' => 1]);
		}
		else
		{
			$update = DB::table('polls')->where('id', $request->input('poll_id'))->update(['moderation_level' => 1]);
		}

		if ($db)
		{
			$request->session()->flash('success', 'Successfully banned user.');
		}
		else
		{
			$request->session()->flash('error', 'Could not ban user.');
		}

		return redirect(action('BlacklistController@index'));
	}

	/**
	 * Show the form for editing the reason for blacklisting.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($user_id)
	{
		$blacklistedUser = Blacklist::with('user')->where('user_id', $user_id)->first();

		return view('blacklist.edit')->with('blacklistedUser', $blacklistedUser);
	}

	/**
	 * Update the specified blacklisted user in storage.
	 *
	 * @param  int $user_id
	 * @return Response
	 */
	public function update(Request $request, $user_id)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id' => 'required|numeric|min:1',
		]);

		$db = DB::table('blacklists')->where('user_id', $user_id)->update(['reason' => $request->input('reason')]);

		return redirect(action('BlacklistController@index'))->with('success', 'Successfully updated the banned user');
	}

	/**
	 * Remove the specified user from the blacklist.
	 *
	 * @param  int $user_id
	 * @return Response
	 */
	public function destroy($user_id)
	{
		$db = DB::table('blacklists')->where('user_id', $user_id)->delete();

		if ($db)
		{
			Session::flash('success', 'Successfully deleted the user from the blacklist.');
		}
		else
		{
			Session::flash('error', 'Could not delete the user from the blacklist.');
		}

		return redirect(action('BlacklistController@index'));
	}

}
