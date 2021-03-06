<?php

namespace App\Http\Controllers;

use Event;
use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VoteMessageRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Events\NewMessageVoteEvent;

use App\Message;
use App\MessageVote;
use App\User;

use Validator;
use Hash;

class VoteMessageController extends Controller
{
	/**
	 * Store a newly created vote on a message in storage.
	 *
	 * @return Response
	 */
	public function store(VoteMessageRequest $request)
	{
    	$message_vote = new MessageVote();
		$message_vote->message_id = $request->input('message_id');
		$message_vote->user_id = $request->input('user_id');

		if(!MessageVote::where('message_id', $message_vote->message_id)
						->where('user_id', $message_vote->user_id)
						->exists())
		{
			$saved = $message_vote->save();

			if ($saved)
			{
				$message = Message::where('id', $message_vote->message_id)->first();
				$message->count++;
				$savedM = $message->save();

				if ($savedM)
				{
					Event::fire(new NewMessageVoteEvent(User::find($message_vote->user_id),$message));

					return redirect()->back()->with('success', 'Message vote success.');
				}
				else
				{
					$message_vote->delete();
					return redirect()->back()->with('error', 'Message could not be incremented.');
				}

				return redirect()->back()->with('success', 'Message vote success.');
			}
			else
			{
				return redirect()->back()->with('error', 'New message vote could not be saved.');
			}
		}
		else
		{
			MessageVote::where('message_id', $message_vote->message_id)
				->where('user_id', $message_vote->user_id)
				->delete();

			$message = Message::where('id', $message_vote->message_id)->first();
			$message->count--;
			$savedM = $message->save();
			
			if($savedM)
			{
				Event::fire(new NewMessageVoteEvent(User::find($message_vote->user_id),$message));
				return redirect()->back()->with('succes', 'Message vote is revoked.');
			}
			else
			{
				return redirect()->back()->with('error', 'Message vote could not be revoked.');
			}

		}
	}
}
