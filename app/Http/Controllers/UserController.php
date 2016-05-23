<?php

namespace App\Http\Controllers;

use App\User;
use Capi\Clients\GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Message;
use App\Poll;
use App\Wall;

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

        //SessionController::updateSpeakers();

        if ($this->ldapAuth($email,$password)) {
            return redirect()->intended('/');
        } else {
            return redirect('login')->with('error', 'Wrong mail and/or password. Please try again.');
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

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first('image'));
        }

        // First check if there was an image uploaded already, if so remove
        $paths = glob(storage_path() . '/app/user_images/' . Auth::user()->id . '*');
        if (count($paths) != 0) {
            unlink($paths[0]);
        }

        $destinationPath = storage_path() . '/app/user_images/';
        $fileName = Auth::user()->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move($destinationPath, $fileName);

        return redirect()->back()->with('info', 'Your profile picture was successfully uploaded.');
    }


    public function showPosts()
    {
        $messages = Message::where('user_id', Auth::user()->id)->where('anonymous', 0)->with('wall')->get();
        $polls = Poll::where('user_id', Auth::user()->id)->with('wall')->get();

        return view('user.posts')->with('messages', $messages)->with('polls', $polls);
    }

    /**
     * Authenticates a user with ldap
     * If the user is unknown to the messagewall it is saved in
     * the great wall's database. A known user's information
     * will be updated instead.
     *
     * @param $email
     * @param $password
     * @return boolean
     */
    private function ldapAuth($email, $password)
    {
        $client = new GuzzleClient();
        try {
            $res = $client->post('auth', 'login', [
                'username' => $email,
                'password' => $password,
            ]);

            if(Auth::attempt(['email' => $email, 'password' => $password]))
            {
                $u = Auth::user();
            }
            else
            {
                $u = new User();
            }

            $u->name = $res['fname'] . ' ' . $res['lname'];
            $u->password = bcrypt($password);

            if (in_array('Messagewall-Admin', $res['roles'])) {
                $u->role = 'Moderator';
            }
            elseif (in_array('Speaker', $res['roles'])) {
                $u->role = 'Speaker';
            } else {
                $u->role = 'Visitor';
            }
            $u->email = $res['email'];

            if (!$u->email || !$u->name || !$u->password || !$u->role) {
                return false;
            }
            $u->save();

            return true;
        } catch (BadResponseException $e) {
            return false;
        }
    }
}
