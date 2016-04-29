<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\ModeratorMessageHandleRequest;
use App\Message;

use Validator;
use Hash;

class MessageController extends Controller
{

	/**
	 * Store a newly created message in storage.
	 *
	 * @return Response
	 */
	public function store(StoreMessageRequest $request)
	{
    $message = new Message();
		$message->user_id = $request->input('user_id');
		$message->wall_id = $request->input('wall_id');
		$message->channel_id = $request->input('channel_id');
		$message->text = $request->input('text');
		$message->anonymous = $request->input('anonymous');

		if ($request->has('question_id'))
		{
			$message->question_id = $request->input('question_id');
		}
		if ($request->has('moderator_id'))
		{
			$message->moderator_id = $request->input('moderator_id');
		}

		$saved = $message->save();
		if ($saved)
		{
			return redirect()->back()->with('success', 'Saved succesfully');
		}
		else
		{
			return redirect()->back()->with('danger', 'Message could not be saved');
		}

	}

	/**
	 * Remove the specified message from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$message = Message::where('id',$id);
		$deleted = $message->delete();
		if($deleted){
			return redirect()->back()->with('success', 'Destroyed succesfully');
		}
		else{
			return redirect()->back()->with('danger', 'Message could not be destroyed');
		}
	}

	/**
	 * Accept the specified message.
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function accept(ModeratorMessageHandleRequest $request)
	{
		$userid = 1; //getfromloggedinuser
		$message_id = $request->input("message_id");
		$message = Message::where("id", "=", $message_id)->first();
		if ($message)
		{
			$message->moderation_level = 0;
			$message->moderator_id = $userid;
			$saved = $message->save();
			if ($saved)
			{
				return redirect()->back()->with("success", "Message was accepted");
			}
			else
			{
				return redirect()->back()->with("danger", "Message could not be saved");
			}
		}
		else
		{
			return redirect()->back()->with("danger", "No message found with this id to be moderated by you");
		}
	}

	/**
	 * Decline the specified message.
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function decline(ModeratorMessageHandleRequest $request)
	{
		$userid = 1; //getfromloggedinuser
		$message_id = $request->input("message_id");
		$message = Message::where("id", "=", $message_id)->first();
		if ($message)
		{
			$message->moderation_level = 1;
			$message->moderator_id = $userid;
			$saved = $message->save();
			if ($saved)
			{
				return redirect()->back()->with("success", "Message was accepted");
			}
			else
			{
				return redirect()->back()->with("danger", "Message could not be saved");
			}
		}
		else
		{
			return redirect()->back()->with("danger", "No message found with this id to be moderated by you");
		}
	}
}