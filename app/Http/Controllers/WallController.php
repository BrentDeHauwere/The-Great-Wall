<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ModeratorMessageHandleRequest;
use App\Wall;
use App\Message;
use App\MessageVote;
use App\Poll;
use App\PollChoice;
use App\PollVote;
use Illuminate\Http\Request;

class WallController extends Controller
{
	/**
	 * Select all questions and polls for  a wall
	 *
	 * @param int $wall_id
	 * @return Response
	 */
	public function openWall($wall_id)
	{
		$wall = Wall::find($wall_id);
		if(empty($wall->password)){
			$messages = Message::with('votes')->where('wall_id', '=', $wall_id)->get();
			$polls = Poll::with('choices.votes')->where('wall_id', '=', $wall_id)->get();

			return view('session')->with('messages', $messages)->with('polls', $polls);
		}
		else{
			redirect()->back()->with("error","No password was provided");
		}

	}

	/**
	 * Handle a new message
	 *
	 * @param StoreMessageRequest
	 * @return Response
	 */
	public function newMessage(StoreMessageRequest $request)
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
			return redirect()->back()->with('error', 'Message could not be saved');
		}
	}

	/**
	 * Handle a vote on a message
	 *
	 * @param VoteMessageRequest
	 * @return Response
	 */
	public function voteMessage(VoteMessageRequest $request)
	{
		$message_vote = new MessageVote();
		$message_vote->message_id = $request->input('message_id');
		$message_vote->user_id = $request->input('user_id');
		$saved = $message_vote->save();
		if ($saved)
		{
			$message = Message::where('id', '=', 'message_id')->first();
			$message->count++;
			$savedM = $message->save;
			if ($savedM)
			{
				return redirect()->back()->with('success', 'Message vote success');
			}
			else
			{
				$message_vote->delete();

				return redirect()->back()->with('error', 'Message could not be incremented');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'New message vote could not be saved');
		}
	}

	/**
	 * Handle a vote on a poll
	 *
	 * @param VotePollRequest
	 * @return Response
	 */
	public function votePoll(VotePollRequest $request)
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

				return redirect()->back()->with('error', 'Poll choice could not be incremented');
			}
		}
		else
		{
			return redirect()->back()->with('error', 'New poll vote could not be saved');
		}

	}

	/**
	 * Get the messages for a moderator
	 *
	 * @param $wall_id
	 * @return Response
	 */
	public function ModeratorQuestions($wall_id)
	{
		$userid = 1; //getfromloggedinuser
		$messages = Message::with("votes")->where("wall_id", "=", $wall_id)->get();
		$polls = Poll::with("choices.votes")->where("wall_id", "=", $wall_id)->get();

		return view("moderator")->with("messages",$messages)->with("polls",$polls);
	}

	/**
	 * Handle an accepted message
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function ModeratorAccept(ModeratorMessageHandleRequest $request)
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
				return redirect()->back()->with("error", "Message could not be saved");
			}
		}
		else
		{
			return redirect()->back()->with("error", "No message found with this id to be moderated by you");
		}

	}

	/**
	 * Handle a declined message
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function ModeratorDecline(ModeratorMessageHandleRequest $request)
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
				return redirect()->back()->with("success", "Message was declined");
			}
			else
			{
				return redirect()->back()->with("error", "Message could not be saved");
			}
		}
		else
		{
			return redirect()->back()->with("error", "No message found with this id to be moderated by you");
		}
	}

	/**
	 * Handle a wall with Password request
	 *
	 * @param ModeratorMessageHandleRequest
	 * @return Response
	 */
	public function enterWallWithPassword(WallPasswordRequest $request){
		$password = $request->input("password");
		$wall_id = $request->input("wall_id");
		$wall = Wall::where("wall_id","=",$wall_id)->where("password","=",$password)->first();
		if($wall){
			$messages = Message::with('votes')->where('wall_id', '=', $wall_id)->get();
			$polls = Poll::with('choices.votes')->with('poll_choices_votes')->where('wall_id', '=', $wall_id)->get();
			return view("messagewall")->with('messages', $messages)->with('polls', $polls);
		}
		else{
			redirect()->back()->with("error","Could not enter the wall with this password");
		}
	}

	public function create(){
		return view('wall_create');
	}

}
