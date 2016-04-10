<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;
use App\MessageVote;
use App\Poll;
use App\PollChoice;
use App\PollVote;

class WallController extends Controller
{
    //expecting wall_id
    public function questions($wall_id){
      $questions = Message::where('wall_id','=',$wall_id)->get();
      $polls = Poll::where('wall_id','=',$wall_id)->get();
      return view('wall')->with('questions',$questions)->with('polls',$polls);
    }

    /*
      expecting user_id
      expecting wall_id
      expecting channel_id
      expecting text
      expecting anonymous
      might have question_id
      might have moderator_id
    */
    public function newMessage(StoreMessageRequest $request){
      $message = new Message();
      $message->user_id = $request->input('user_id');
      $message->wall_id = $request->input('wall_id');
      $message->channel_id = $request->input('channel_id');
      $message->text = $request->input('text');
      $message->anonymous = $request->input('anonymous');
      if($request->has('question_id')){
        $message->question_id = $request->input('question_id');
      }
      if($request->has('moderator_id')){
        $message->moderator_id = $request->input('moderator_id');
      }

      $saved = $message->save();
      if($saved){
        return redirect()->back()->with('success','Saved succesfully');
      }
      else{
        return redirect()->back()->with('error','Message could not be saved');
      }
    }

    /*
      expecting message_id
      expecting user_id
    */
    public function voteMessage(VoteMessageRequest $request){
      $message_vote = new MessageVote();
      $message_vote->message_id = $request->input('message_id');
      $message_vote->user_id = $request->input('user_id');
      $saved = $message_vote->save();
      if($saved){
        $message = Message::where('id','=','message_id')->first();
        $message->count++;
        $savedM = $message->save;
        if($savedM){
          return redirect()->back()->with('success','Message vote success');
        }
        else{
          $message_vote->delete();
          return redirect()->back()->with('error','Message could not be incremented');
        }
      }
      else{
        return redirect()->back()->with('error','New message vote could not be saved');
      }
    }

    /*
      expecting poll_choice_id
      expecting user_id
    */
    public function votePoll(votePollRequest $request){
      $poll_vote = new PollVote();
      $poll_vote->poll_choice_id = $request->input('poll_choice_id');
      $poll_vote->user_id = $request->input('user_id');
      $saved = $poll_vote->save();
      if($saved){
        $pollchoice = PollChoice::where('id','=','message_id')->first();
        $pollchoice->count++;
        $savedChoice = $pollchoice->save();
        if($savedChoice){
          return redirect()->back()->with('success','Poll vote success');
        }
        else{
          $poll_vote->delete();
          return redirect()->back()->with('error','Poll choice could not be incremented');
        }
      }
      else{
        return redirect()->back()->with('error','New poll vote could not be saved');
      }

    }
}
