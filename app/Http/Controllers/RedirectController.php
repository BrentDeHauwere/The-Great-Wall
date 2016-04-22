<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RedirectController extends Controller
{
    /**
    * Redirects the moderator/presentor to the page where they can create a wall.
    *
    * return view createWall.blade.php
    */
    public function createWall(){
      return view('createWall');
    }
}
