<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SessionController extends Controller
{
	/**
	 * Show an overview of the walls.
	 *
	 * @return Response
	 */
	public function index()
	{
		$walls = Wall::all();

		return View::make('sessions.index')
			->with('sessions', $walls);
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
	public function store()
	{
		// Server-side validation
		$rules = array(
			'name'		=> 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('sessions/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else
		{
			$wall = new Wall;
			$wall->name = Input::get('name');
			$wall->save();

			Session::flash('message', 'Successfully created wall.');
			return Redirect::to('sesions');
		}
	}

	/**
	 * Display the specified wall.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$wall = Wall::find($id);

		return View::make('sessions.show')
			->with('wall', $wall);
	}

	/**
	 * Show the form for editing the specified wall.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$wall = Wall::find($id);

		return View::make('sessions.edit')
			->with('wall', $wall);
	}

	/**
	 * Update the specified wall in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name'       => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to("sessions/{$id}/edit")
				->withErrors($validator)
				->withInput(Input::except('password'));
		}
		else
		{
			$wall = Wall::find($id);
			$wall->name = Input::get('name');
			$wall->save();

			Session::flash('message', 'Successfully updated wall.');
			return Redirect::to('sessions');
		}
	}

	/**
	 * Remove (inactive) the specified wall from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$wall = Wall::find($id);
		$wall->delete();

		Session::flash('message', 'Successfully deleted the wall.');
		return Redirect::to('sessions');
	}
}
