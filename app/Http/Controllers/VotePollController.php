<?php

namespace App\Http\Controllers;

use Auth;
use Event;
use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VotePollRequest;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\User;
use App\Poll;
use App\PollChoice;
use App\PollVote;
use App\Events\NewPollVoteEvent;

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
        $poll_vote->user_id = Auth::user()->id;
        $saved = false;

        // clicked choice
        $pollChoice = PollChoice::where('id', $poll_vote->poll_choice_id)->first();

        // corresponding poll with votes of this user
        $poll = Poll::with(['choices.votes' => function ($query) use ($poll_vote) {
            $query->where('user_id', $poll_vote->user_id);
        }])->where('id', $pollChoice->poll_id)->first();

        // check if multiple votes already exist
        $existingVotes = 0;
        foreach ($poll->choices as $choice) {
            foreach ($choice->votes as $vote) {
                $existingVotes += 1;
            }
            if ($existingVotes > 1) {
                break;
            }
        }

        // if multiple votes -> delete
        if ($existingVotes > 0) {
            foreach ($poll->choices as $choice) {
                foreach ($choice->votes as $vote) {
                    $same = false;

                    if($poll_vote->equals($vote))
                    {
                        $same=true;
                    }

                    $pv = $choice->votes->filter(function ($v) use ($poll_vote) {
                        return ($v->user_id == $poll_vote->user_id);
                    })->first();

                    DB::delete('delete from poll_votes where poll_choice_id = ? and user_id = ?',
                        array($pv->poll_choice_id, $pv->user_id));

                    $choice->count -= 1;
                    $choice->save();
                }
            }
            if($same)
            {
                return redirect()->back()->with('success', 'Poll vote revoked.');
            }
            $saved = $poll_vote->save();
        } else {
            $saved = $poll_vote->save();
        }

        if ($saved) {
            $pollchoice = PollChoice::where('id', $poll_vote->poll_choice_id)->first();

            $pollchoice->count++;
            $savedChoice = $pollchoice->save();

            if ($savedChoice) {
                /*$client = new \Capi\Clients\GuzzleClient();
                $response = $client->post('broadcast', 'msg1.polls.vote',['pollvote' => $poll_vote]);*/


                $choices = PollChoice::where('poll_id',$pollchoice->poll->id)->get();
                $count = 0;
                foreach($choices as $choice){
                  $count += $choice->count;
                }
                foreach($choices as $choice){
                    $c = 0;
                    if($count != 0){
                      $c = $choice->count/$count;
                    }
                    if(PollVote::where('user_id',Auth::user())->where('poll_choice_id',$choice->id)->first()){
                      Event::fire(new NewPollVoteEvent($choice,round($c*100),true));
                    }
                    else{
                      Event::fire(new NewPollVoteEvent($choice,round($c*100),false));
                    }

                }
                return redirect()->back()->with('success', 'Poll vote success.');
            } else {
                $poll_vote->delete();
                return redirect()->back()->with('error', 'Poll choice could not be incremented.');
            }
        } else {
            dd('KAK');
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
        if ($deleted) {
            $poll = PollChoice::where('id', '=', $pollvote->poll_id)->first();
            $poll->count--;
            $savedP = $poll->save;
            if ($savedP) {
                return redirect()->back()->with('success', 'Poll unvote success.');
            } else {
                $pollvote->delete();

                return redirect()->back()->with('error', 'Poll could not be unincremented.');
            }
        } else {
            return redirect()->back()->with('error', 'Poll vote could not be undone.');
        }
    }



}
