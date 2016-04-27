<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wall;
use App\Message;
use App\Poll;
use App\Blacklist;
use DB;

class ApiController extends Controller
{
  public function walls(){

    $walls = Wall::all();

    foreach($walls as $wall){
      //remove deleted_at property
      unset($wall->deleted_at);

      //remove password
      unset($wall->password);

      //Convert timestamp to unix format
      $wall->created_at = strtotime($wall->created_at);
    }

    return response()->json($walls);
  }

  public function messages(){
    return response()->json(Message::all());
  }

  public function polls(){
    return response()->json(Poll::all());
  }

  public function blacklist(){
    //$blacklistedUsers = Blacklist::all();
    $db = DB::table('blacklists')->select('user_id', 'reason', 'created_at')->get();

    //format results to match JSON-document
    foreach($db as $usr){

      $temp_userid = $usr->user_id;
      unset($usr->user_id);

      $usr->user = ["user_id" => $temp_userid, "name" => "moet nog gebeuren"];

      //Convert timestamp to unix format
      $usr->created_at = strtotime($usr->created_at);
    }

    return response()->json($db);
  }
}
