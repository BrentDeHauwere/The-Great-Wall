<?php

namespace App\Http\Controllers;

use App\PollChoice;
use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePollChoiceRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Validator;
use Hash;

class PollChoiceController extends Controller
{
	/**
	 * Store a newly created poll in storage.
	 * @param Request
	 * @return Response
	 */
	public function store(StorePollChoiceRequest $request)
	{
		$pollChoice = new PollChoice();
		$pollChoice->poll_id = $request->input('poll_id');
		$pollChoice->user_id = $request->input('user_id');
		$pollChoice->text = $request->input('text');
		$pollChoice->created_at = date('Y-m-d H:i:s');

		/* // NOT IMPLEMENTED YET
		if ( $request->has('moderator_id') )
		{
			$pollChoice->moderator_id = $request->input('moderator_id');
		}
		*/

		$succes = $pollChoice->save();

		if ( $succes == true )
		{
			/*$client = new \Capi\Clients\GuzzleClient();
			$response = $client->post('broadcast', 'msg1.polls.choices',['pollchoice' => $pollChoice]);*/

			return redirect()->back()->with('success', 'Pollchoice success');
		}
		else
		{
			return redirect()->back()->with('danger', 'New pollchoice could not be saved');
		}
	}

	/**
	 * Remove  the specified poll from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$message = Poll::where('id', $id);
		$deleted = $message->delete();
		if ( $deleted )
		{
			return redirect()->back()->with('success', 'Destroyed succesfully');
		}
		else
		{
			return redirect()->back()->with('danger', 'Pollchoice could not be destroyed');
		}
	}
}
