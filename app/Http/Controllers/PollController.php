<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Poll;

use Validator;
use Hash;

class PollController extends Controller
{

	/**
	 * Store a newly created message in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

	}

	/**
	 * Remove  the specified message from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
	}
}
