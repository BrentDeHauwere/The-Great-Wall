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

        if ($this->ldapAuth($email, $password)) {
           if(!self::checkCRMbanned(Auth::user())){
                return redirect('login')->with('error', 'An error occured. Please try again.');
            }
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

        $validator = Validator::make($request->all(), [
            'twitter_handle' => 'required|unique:users,twitter_handle',
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Please provide a unique twitter handle.');
        }

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
     * If the user is banned in crm then it's banned in the messagewall.
     *
     */
    public static function checkCRMbanned(User $u)
    {
        $client = new GuzzleClient();
        try {
            $res = $client->get('crm', 'person-get', ['email' => $u->email]);
            $user = $res['data'][0];
            if (in_array('locked', $user['roles'])) {
                if (User::where('email', $user['email'])->first()) {
                    $u = User::where('email', $user['email'])->first();
                    if (!$u->banned()) {
                        BlacklistController::storeUser($u);
                    }
                    return true;
                }
                else {
                    return true;
                }
            }
            return true;
        } catch (BadResponseException $e) {
            // wanneer crm down of user niet vindt -> so be it.
            return true;
        }
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

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = new User();
            }

            $user->name = $res['fname'] . ' ' . $res['lname'];
            $user->password = bcrypt($password);

            if (in_array('Messagewall-Admin', $res['roles'])) {
                $user->role = 'Moderator';
            } elseif (in_array('Speaker', $res['roles'])) {
                $user->role = 'Speaker';
            } else {
                $user->role = 'Visitor';
            }
            $user->email = $res['email'];

            if (!$user->email || !$user->name || !$user->password || !$user->role) {
                return false;
            }

            $user->save();

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return true;
            }
        } catch (BadResponseException $e) {
            if ($e->getCode() == '404') {
                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }
}
