<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wall;
use App\Message;
use App\Poll;

class ApiController extends Controller
{
  public function walls(){
    return response()->json(Wall::all());
  }

  public function messages(){
    return response()->json(Message::all());
  }

  public function polls(){
    return response()->json(Poll::all());
  }
}
