<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Validator;
use Hash;

class SessionController extends Controller
{
	/**
	 * Show an overview of the walls.
	 *
	 * @return Response
	 */
	public function index()
	{
		$walls = Wall::orderBy('name')->get();

		return View::make('sessions.index')
			->with('walls', $walls);
	}

	/**
	 * Show the form for creating a new wall.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}

	/**
	 * Store a newly created wall in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id' 	=> 'required|numeric|min:1',
			'name'    	=> 'required',
			'password'	=> 'confirmed',
		]);

		$wall = new Wall;
		$wall->user_id = $request->input('user_id');
		$wall->name = $request->input('name');
		if ($request->has('password'))
		{
			$wall->password = Hash::make($request->input('password'));
		}
		$wall->save();

		$request->session()->put('message', 'Successfully created wall.');

		return Redirect::to('TheGreatWall/sessions');
	}


	/**
	 * Display the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function show($id)
	{
		$wall = Wall::find($id);

		return View::make('sessions.show')
			->with('wall', $wall);
	}

	/**
	 * Show the form for editing the specified wall.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function edit($id)
	{
		$wall = Wall::find($id);

		return View::make('sessions.edit')
			->with('wall', $wall);
	}

	/**
	 * Update the specified wall in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function update(Request $request, $id)
	{
		// Server-side validation
		$this->validate($request, [
			'user_id' 	=> 'required|numeric|min:1',
			'name'    	=> 'required',
			'password'	=> 'confirmed',
		]);

		$wall = Wall::find($id);
		$wall->user_id = $request->input('user_id');
		$wall->name = $request->input('name');
		if ($request->has('password'))
		{
			$wall->password = Hash::make($request->input('password'));
		}
		else
		{
			$wall->password = null;
		}
		$wall->save();

		$request->session()->put('message', 'Successfully updated wall.');

		return Redirect::to('TheGreatWall/sessions');
	}

	/**
	 * Remove (inactive) the specified wall from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public
	function destroy($id)
	{
		$wall = Wall::find($id);
		$wall->delete();

		Session::flash('message', 'Successfully deleted the wall.');

		return Redirect::to('TheGreatWall/sessions');
	}
}