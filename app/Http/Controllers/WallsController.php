<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wall;
use App\Http\Requests;

class WallsController extends Controller
{
  /**
  * Displays all the available walls
  *
  * return view walls.blade.php with walls
  */
    public function index(){
      $walls = Wall::all();
      return view('walls', compact('walls'));
    }

    /**
    * Displays JSON of a wall (temporary solution, DELETE THIS WHEN THE VIEW FOR A WALL IS CREATED BY KAMIELTJE)
    *
    * returns wall
    */
    public function show(Wall $wall){
      return $wall;
    }

    public function create(){
      return view('wall_create');
    }

    /**
    * Stores a wall in the database
    *
    * return view walls.blade.php when succesfull, error when failed
    */
    public function store(Request $request){
      $wall = new Wall;
      $wall->name = $request->input('name');
      if (!empty($request->input('password'))){
        $wall->password = bcrypt($request->input('password'));
      }

      $saved = $wall->save();

      if($saved){
        return view('walls');
      } else {
        return redirect()->back()->with('error', 'Wall could not be created.');
      }
    }
}
