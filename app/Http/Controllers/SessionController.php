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

		foreach($walls as $wall){
			if (!empty($wall->password)){
				$wall->password = "Yes";
			}
		}

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

		Session::flash('info', 'Successfully created wall.');

		return Redirect::to('sessions');
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
			->with('wall', $wall)->with('success','Something');
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

		Session::flash('info', 'Successfully updated wall.');

		return Redirect::to('sessions');
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

		Session::flash('info', 'Successfully deleted the wall.');

		return Redirect::to('sessions');
	}
}
