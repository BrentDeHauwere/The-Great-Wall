<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Blacklist;
use DB;
use Session;

class BlacklistController extends Controller
{
  /**
	 * Show an overview of the blacklisted users.
	 *
	 * @return Response
	 */
	public function index()
	{
		$blacklistedUsers = Blacklist::orderBy('created_at')->get();

		return view('blacklist.index')->with('blacklistedUsers', $blacklistedUsers);
	}

  /**
	 * Show the form for editing the reason for blacklisting.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function edit($user_id)
	{
    $blacklistedUser = DB::table('blacklists')->where('user_id', $user_id)->first();
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
			'user_id' 	=> 'required|numeric|min:1',
		]);

		$db = DB::table('blacklists')->where('user_id', $user_id)->update(['reason' => $request->input('reason')]);

		return redirect('TheGreatWall/blacklist');
	}

  /**
	 * Remove the specified user from the blacklist.
	 *
	 * @param  int $user_id
	 * @return Response
	 */
	public
	function destroy($user_id)
	{
		$db = DB::table('blacklists')->where('user_id', $user_id)->delete();

    if ($db){
      Session::flash('message', 'Successfully deleted the user from blacklist.');
    } else {
      Session::flash('message', 'Could not delete the user from blacklist.');
    }


		return redirect('TheGreatWall/blacklist');
	}
}
