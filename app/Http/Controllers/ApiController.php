<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wall;
use App\Message;
use App\Poll;
use App\Blacklist;
use App\user;
use DB;

class ApiController extends Controller
{
  public function walls(){

    $walls = DB::table('walls')->select('id', 'name', 'user_id', 'created_at')->get();

    foreach($walls as $wall){

      //id formatting to wall_id
      $wall->wall_id = $wall->id;
      unset($wall->id);

      //user_id formatting to creator{userid, name}
      $user = User::find($wall->user_id);

      if (empty($user->name)){
        $wall->creator = ["user_id" => $wall->user_id, "name" => "Not found."];
      } else {
        $wall->creator = ["user_id" => $wall->user_id, "name" => $user->name];
      }

      unset($wall->user_id);

      //Convert timestamp to unix format
      $wall->created_at = strtotime($wall->created_at);
    }

    return response()->json($walls);
  }

  public function messages(){

    $messages = Message::all();

    foreach($messages as $msg){
      //format id to message_id
      $msg->message_id = $msg->id;
      unset($msg->id);

      //format user_id to creator{userid, name} if not anonymous
      if ($msg->anonymous == 1){
        $msg->creator = null;
      } else {
        $user = User::find($msg->user_id);
        $msg->creator = ["user_id" => $msg->user_id, "name" => $user->name];
      }
      unset($msg->anonymous);

      unset($msg->moderation_level);

      //format count to votes
      $msg->votes = $msg->count;
      unset($msg->count);

      //if message is a response to another message, send message with repsonse message
      if(!empty($msg->question_id)){
        
      }

      //format timestamp to unix format
      $msg->created_at = strtotime($msg->created_at);

    }

    return response()->json($messages);
  }

  public function polls(){
    return response()->json(Poll::all());
  }

  public function blacklist(){
    $db = DB::table('blacklists')->select('user_id', 'reason', 'created_at')->get();

    //format results to match JSON-document
    foreach($db as $usr){

      //user_id formatting to user{user_id, name}
      $user = User::find($usr->user_id);
      $temp_userid = $usr->user_id;
      unset($usr->user_id);
      $usr->user = ["user_id" => $temp_userid, "name" => $user->name];

      //Convert timestamp to unix format
      $usr->created_at = strtotime($usr->created_at);
    }

    return response()->json($db);
  }
}
