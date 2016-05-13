<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	/**
	 * Authenticate a user.
	 *
	 * @param Request
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

		if (Auth::attempt(['email' => $email, 'password' => $password])) {
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
	 * @param Request
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();
		return redirect('login')->with('success', 'Successfully logged out.');
	}
}
