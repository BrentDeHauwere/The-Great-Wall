<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	/**
	 * Show the view to authenticate a user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('login');
	}

	/**
	 * Authenticate a user.
	 *
	 * @param Request
	 * @return Response
	 */
	public function login(Request $request)
	{
		$email = $request->input('email');
		$password = $request->input('password');

		if (Auth::attempt(['email' => $email, 'password' => $password]))
		{
			return redirect()->intended('/');
		}
		else
		{
			return view('login')->with('error', 'Wrong mail and/or password. Please try again.');
		}
	}

	/**
	 * Log a user out.
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();

		return redirect('login')->with('success', 'Successfully logged out.');
	}

	/**
	 * Set the Twitter handle for a user.
	 *
	 * @param Request
	 * @return Response
	 */
	public function twitterHandle(Request $request)
	{
		if (Auth::user()->twitter_handle != null)
			abort(403);

		$this->validate($request, [
			'twitter_handle' => 'required',
		]);

		$user = Auth::user();
		$user->twitter_handle = $request->input('twitter_handle');
		$user->save();

		return redirect()->back()->with('success', 'Your Twitter handle was set.');
	}

	/**
	 * Set an image for a user.
	 *
	 * @param Request
	 * @return Response
	 */
	public function image(Request $request)
	{
		// Server-side validation
		$validator = Validator::make($request->all(), [
			'image' => 'required|image',
		]);

		if ($validator->fails())
		{
			return redirect()->back()
				->with('error', $validator->errors->first('image'));
		}

		// First check if there was an image uploaded already, if so remove
		$paths = glob(storage_path() . '/app/wall_images/' . Auth::user()->id . '*');
		if (count($paths) != 0)
		{
			unlink($paths[0]);
		}

		$destinationPath = storage_path() . '/app/wall_images/';
		$fileName = Auth::user()->id . '.' . $request->file('image')->getClientOriginalExtension();
		$request->file('image')->move($destinationPath, $fileName);

		return redirect()->back()->with('success', 'Your profile picture was successfully uploaded.');
	}
}
