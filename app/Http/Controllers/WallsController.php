<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wall;
use App\Http\Requests;

class WallsController extends Controller
{
    public function index(){
      $walls = Wall::all();
      return view('walls', compact('walls'));
    }

    public function show(Wall $wall){
      if (!empty($wall->password)){
        return view('enterpassword', compact('wall'));
      }
      return $wall;
    }

    public function enter(Request $request, Wall $wall){
      if ($request->password == $wall->password){
        return $wall;
      }
      return view('enterpassword', compact('wall'));
    }
}
