<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Event;
use App\PollChoice;
use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePollChoiceRequest;
use App\Http\Requests\ModeratorPollChoiceHandleRequest;
use App\Events\NewPollChoiceModeratorAcceptEvent;
use App\Events\NewPollChoiceModeratorDeclineEvent;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Events\NewPollChoiceEvent;

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
			Log::info('Events gonna get fired');
			Event::fire(new NewPollChoiceEvent($pollChoice));

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

	/**
	 * Accept the specified poll choice.
	 *
	 * @param ModeratePollChoiceHandleRequest
	 * @return Response
	 */
	public
	function accept(ModeratePollChoiceHandleRequest $request)
	{
		$userid = Auth::user()->id; //getfromloggedinuser
		$poll_choice_id = $request->input("poll_choice_id");
		$poll_choice= PollChoice::where("id", $poll_choice_id)->first();
		if ($poll_choice) {
			if ($poll_choice->moderation_level != 0) {
				$poll_choice->moderation_level = 0;
			}

			$poll_choice->moderator_id = $userid;
			$saved = $poll_choice->save();
			if ($saved) {
				Event::fire(new NewPollChoiceModeratorAcceptEvent($poll_choice));

				return redirect()->back()->with("success", "poll choice was accepted.");
			} else {
				return redirect()->back()->with("error", "poll choice could not be saved.");
			}
		} else {
			return redirect()->back()->with("error", "No poll choice found with this id to be moderated by you.");
		}
	}


	/**
	 * Decline the specified poll choice.
	 *
	 * @param ModeratePollChoiceHandleRequest
	 * @return Response
	 */
	public
	function decline(ModeratorPollChoiceHandleRequest $request)
	{
		$userid = Auth::user()->id; //getfromloggedinuser
		$poll_choice_id = $request->input("poll_choice_id");
		$poll_choice = PollChoice::where("id", $poll_choice_id)->first();

		if ($poll_choice) {
			$poll_choice->moderation_level = 1;
			$poll_choice->moderator_id = $userid;

			$saved = false;
			// $saved = $poll_choice->save();
			
			if ($saved) {
				Event::fire(new NewPollChoiceModeratorDeclineEvent($poll_choice));

				return redirect()->back()->with("success", "poll choice was blocked.");
			} else {
				return redirect()->back()->with("error", "poll choice could not be saved want Brent ofzo moet is in de migrations aanpassen dat een poll choice een moderator_id heeft.");
			}
		} else {
			return redirect()->back()->with("error", "No poll choice found with this id to be moderated by you.");
		}
	}
}
