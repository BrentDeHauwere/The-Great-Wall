<?php

namespace App\Http\Controllers;

use App\PollChoice;
use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePollRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Poll;

use Validator;
use Hash;

class PollController extends Controller
{
	/**
	 * Store a newly created poll in storage.
	 * @param Request
	 * @return Response
	 */
	public function store(StorePollRequest $request)
	{
		$poll = new Poll();
		$poll->user_id = $request->input('user_id');
		$poll->wall_id = $request->input('wall_id');

		// $poll->channel_id = $request->input('channel_id');

		$poll->question = $request->input('question');
		$poll->addable = $request->input('addable');
		$poll->created_at = date('Y-m-d H:i:s');

		if ( $request->has('moderator_id') )
		{
			$poll->moderator_id = $request->input('moderator_id');
		}

		$savedPoll = $poll->save();

		$succes = false;
		if ( $savedPoll )
		{
			// save the pollOptions
			$choices = $request->input('choices');

			foreach ($choices as $choice)
			{
				$pollChoice = new PollChoice();

				$pollChoice->poll_id = $poll->id;
				$pollChoice->user_id = $poll->user_id;
				$pollChoice->text = $choice;
				$pollChoice->created_at = date('Y-m-d H:i:s');

				$savedChoice = $pollChoice->save();

				if ( $savedChoice )
				{
					$succes = true;
				} else {
					$succes = false;
				}
			}
		}

		if ( $succes == true )
		{
			return redirect()->back()->with('success', 'Poll success');
		}
		else
		{
			return redirect()->back()->with('danger', 'New poll could not be saved');
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
		$poll = Poll::where('id', $id);
		$deleted = $poll->delete();
		if ( $deleted )
		{
			return redirect()->back()->with('success', 'Destroyed succesfully');
		}
		else
		{
			return redirect()->back()->with('danger', 'Poll could not be destroyed');
		}
	}
}
