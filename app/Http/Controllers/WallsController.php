<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//Deze klasse is enkel om te testen. Als de models en de db in orde is kunnen we onderstaande code verwijderen.
class Wall {
  public $id;
  public $name;
  public $createdBy;
  public $password;
}

class WallsController extends Controller
{
    public function index(){
      //$walls = Walls::all();
      $myWall = new Wall();
      $myWall->id = 1;
      $myWall->name = "Wall 1";
      $myWall->createdBy = "Jonas";
      $myWall->password = "";

      $myWall2 = new Wall();
      $myWall2->id = 2;
      $myWall2->name = "Wall 2";
      $myWall2->createdBy = "Jonas";
      $myWall2->password = "password";

      $walls = array($myWall, $myWall2);

      return view('walls', compact('walls'));
    }
}
