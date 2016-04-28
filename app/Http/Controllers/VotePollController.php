<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Poll;
use App\PollChoice;
use App\PollVote;

use Validator;
use Hash;

class VotePollController extends Controller
{


	/**
	 * Store a newly created vote on a poll in storage.
	 *
	 * @return Response
	 */
	public function store(VotePollRequest $request)
	{
    $poll_vote = new PollVote();
		$poll_vote->poll_choice_id = $request->input('poll_choice_id');
		$poll_vote->user_id = $request->input('user_id');
		$saved = $poll_vote->save();
		if ($saved)
		{
			$pollchoice = PollChoice::where('id', '=', 'message_id')->first();
			$pollchoice->count++;
			$savedChoice = $pollchoice->save();
			if ($savedChoice)
			{
				return redirect()->back()->with('success', 'Poll vote success');
			}
			else
			{
				$poll_vote->delete();

				return redirect()->back()->with('danger', 'Poll choice could not be incremented');
			}
		}
		else
		{
			return redirect()->back()->with('danger', 'New poll vote could not be saved');
		}
	}

	/**
	 * Remove (inactive) the specified vote on a poll from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function destroy($id)
	{
    $messagevote = PollVote::where('id','=',$id);
    $deleted = $messagevote->delete();
    if ($deleted)
		{
			$message = PollChoice::where('id', '=', $messagevote->message_id)->first();
			$message->count--;
			$savedM = $message->save;
			if ($savedM)
			{
				return redirect()->back()->with('success', 'Poll unvote success');
			}
			else
			{
				$message_vote->delete();

				return redirect()->back()->with('danger', 'Poll could not be unincremented');
			}
		}
		else
		{
			return redirect()->back()->with('danger', 'Poll vote could not be undone');
		}
	}
}
