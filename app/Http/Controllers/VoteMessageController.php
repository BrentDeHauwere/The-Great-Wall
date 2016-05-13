<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VoteMessageRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Message;
use App\MessageVote;

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
					return redirect()->back()->with('success', 'Message vote success.');
				}
				else
				{
					$message_vote->delete();

					return redirect()->back()->with('error', 'Message could not be incremented.');
				}
			}
			else
			{
				return redirect()->back()->with('error', 'New message vote could not be saved.');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'Message vote already exists.');
		}
	}

	/**
	 * Remove (inactive) the specified vote on a message from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function destroy($id)
	{
    $messagevote = MessageVote::where('id','=',$id);
    $deleted = $messagevote->delete();
    if ($deleted)
		{
			$message = Message::where('id', '=', $messagevote->message_id)->first();
			$message->count--;
			$savedM = $message->save;
			if ($savedM)
			{
				return redirect()->back()->with('success', 'Message unvote success.');
			}
			else
			{
				$messagevote->delete();

				return redirect()->back()->with('error', 'Message could not be unincremented.');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'Message vote could not be undone');
		}
	}
}
