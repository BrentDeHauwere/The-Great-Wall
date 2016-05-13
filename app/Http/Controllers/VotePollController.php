<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VotePollRequest;
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

		$saved = false;

		// clicked choice
		$pollChoice = PollChoice::where('id', $poll_vote->poll_choice_id)->first();

		// corresponding poll
		$poll = Poll::with([ 'choices.votes' => function ($query) use ($poll_vote)
		{
			$query->where('user_id', $poll_vote->user_id);
		} ])->where('id', $pollChoice->poll_id)->first();


		// check if multiple votes already exist, if so --> delete them
		$existingVotes = 0;
		foreach ($poll->choices as $choice)
		{
			foreach ($choice->votes as $vote)
			{
				$existingVotes += 1;
			}
			if ( $existingVotes > 1 )
			{
				break;
			}
		}

		// if multiple votes -> delete
		if ( $existingVotes > 0 )
		{
			foreach ($poll->choices as $choice)
			{
				foreach ($choice->votes as $vote)
				{
					// PollVote::destroy([$vote->poll_choice_id, $vote->user_id]);
					$votes=Pollvote::with(['choice.votes' => function ($query) use ($vote)
					{
						$query->where('user_id', $vote->user_id);
					}])->delete();
					$choice->count-=1;
					$choice->save();
				}
			}
			$saved = $poll_vote->save();
		}
		else
		{
			$savenew = true;
			foreach ($poll->choices as $choice)
			{
				if ( $choice->votes->contains($poll_vote) )
				{
					// if contains -> get out and do nothing :)
					$savenew = false;
					break;
				}
			}
			if ( $savenew )
			{
				$saved = $poll_vote->save();
			}
		}


		if ( $saved )
		{
			$pollchoice = PollChoice::where('id', $poll_vote->poll_choice_id)->first();

			$pollchoice->count++;
			$savedChoice = $pollchoice->save();

			if ( $savedChoice )
			{
				return redirect()->back()->with('success', 'Poll vote success.');
			}
			else
			{
				$poll_vote->delete();
				return redirect()->back()->with('error', 'Poll choice could not be incremented.');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'New poll vote could not be saved.');
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
		$pollvote = PollVote::where('id', '=', $id);
		$deleted = $pollvote->delete();
		if ( $deleted )
		{
			$poll = PollChoice::where('id', '=', $pollvote->poll_id)->first();
			$poll->count--;
			$savedP = $poll->save;
			if ( $savedP )
			{
				return redirect()->back()->with('success', 'Poll unvote success.');
			}
			else
			{
				$pollvote->delete();
				return redirect()->back()->with('error', 'Poll could not be unincremented.');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'Poll vote could not be undone.');
		}
	}
}
