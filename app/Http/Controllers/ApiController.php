<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wall;
use App\Message;
use App\Poll;
use App\Blacklist;
use App\user;

class ApiController extends Controller
{
  /**
  * Returns all the walls in JSON-format
  *
  * @return all walls in JSON.
  */
  public function walls(){

    $walls = Wall::all();

    foreach($walls as $wall){
      $wall = ApiController::formatWall($wall);
    }

    return response()->json($walls);
  }

  /**
  * Returns all the messages in JSON-format
  *
  * @return all messages in JSON.
  */
  public function messages(){

    $messages = Message::all();

    foreach($messages as $msg){
     $msg = ApiController::formatMessage($msg);
    }

    return response()->json($messages);
  }

  /**
  * Returns all the polls in JSON-format
  *
  * @return all polls in JSON.
  */
  public function polls(){

    $polls = Poll::all();

    foreach($polls as $poll){

      //rename id to poll_id
      $poll->poll_id = $poll->id;

      //format wall_id to wall
      $poll->wall = ApiController::formatWall(Wall::find($poll->wall_id));

      //format user_id to user{user_id, name}
      $user = User::find($poll->user_id);

      if (!empty($user)){
        $poll->creator = ["user_id" => $user->id, "name" => $user->name];
      } else {
        $poll->creator = null;
      }

      //Convert timestamp to unix format
      $poll->created_at = strtotime($poll->created_at);

      //rename question to text
      $poll->text = $poll->question;

      unset($poll->id);
      unset($poll->wall_id);
      unset($poll->user_id);
      unset($poll->moderation_level);
      unset($poll->question);
      unset($poll->addable);
    }

    return response()->json($polls);
  }

  /**
  * Returns all the blacklisted users in JSON-format
  *
  * @return all blacklisted users in JSON.
  */
  public function blacklist(){
    $blacklist = Blacklist::all();

    //format results to match JSON-document
    foreach($blacklist as $usr){

      //user_id formatting to user{user_id, name}
      $user = User::find($usr->user_id);
      $temp_userid = $usr->user_id;
      $usr->user = ["user_id" => $temp_userid, "name" => $user->name];

      //Convert timestamp to unix format
      $usr->created_at = strtotime($usr->created_at);

      //remove unwanted properties
      unset($usr->user_id);
    }

    return response()->json($blacklist);
  }

  /**
  * Formats a message for use in the API.
  *
  * @param Message message to be formatted
  * @return formatted message.
  */
  private function formatMessage(Message $msg){
    //format id to message_id
    $msg->message_id = $msg->id;

    //format user_id to creator{userid, name} if not anonymous
    if ($msg->anonymous == 1){
      $msg->creator = null;
    } else {
      $user = User::find($msg->user_id);
      $msg->creator = ["user_id" => $msg->user_id, "name" => $user->name];
    }

    //format count to votes
    $msg->votes = $msg->count;

    //format question_id to question_id
    $msg->question = $msg->question_id;

    //if message is a response to another message, send message with repsonse message
    if(!empty($msg->question)){
      $msg2 = Message::find($msg->question);
      $msg->question = ApiController::formatMessage($msg2);
    }

    //format wall_id to wall{wall_id, name, creator{user_id, name}}
    $wall = Wall::findOrFail($msg->wall_id);
    $msg->wall = ApiController::formatWall($wall);

    //format timestamp to unix format
    $msg->created_at = strtotime($msg->created_at);

    //unset unwanted properties
    unset($msg->id);
    unset($msg->user_id);
    unset($msg->anonymous);
    unset($msg->moderation_level);
    unset($msg->channel_id);
    unset($msg->count);
    unset($msg->question_id);
    unset($msg->wall_id);

    return $msg;
  }

  /**
  * Formats a wall for use in the API.
  *
  * @param Wall wall to be formatted
  * @return formatted wall.
  */
  private function formatWall(Wall $wall){
    //id formatting to wall_id
    $wall->wall_id = $wall->id;

    //user_id formatting to creator{userid, name}
    $user = User::find($wall->user_id);

    if (empty($user->name)){
      $wall->creator = ["user_id" => $wall->user_id, "name" => "Not found."];
    } else {
      $wall->creator = ["user_id" => $wall->user_id, "name" => $user->name];
    }

    //unset unwanted properties
    unset($wall->id);
    unset($wall->user_id);
    unset($wall->password);
    unset($wall->open_until);
    unset($wall->deleted_at);

    //Convert timestamp to unix format
    $wall->created_at = strtotime($wall->created_at);

    return $wall;
  }
}
