<?php

namespace App\Http\Controllers;

use App\User;
use App\Wall;
use Illuminate\Http\Request;

use Capi\Clients\GuzzleClient;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Message;
use App\Poll;
use Validator;
use Hash;
use DB;
use Auth;
use App\Blacklist;

class SessionController extends Controller
{
    /**
     * Show an overview of the walls.
     *
     * @return Response
     */
    public function index()
    {
        $walls = Wall::withTrashed()->with('user')->orderBy('name')->get();

        foreach ($walls as $wall) {
            if (!empty($wall->password)) {
                $wall->password = "Yes";
            } else {
                $wall->password = "No";
            }

            if ($wall->deleted_at != null) {
                $wall->open_until = 'Manually closed';
            } else if ($wall->open_until == null) {
                $wall->open_until = 'Infinity (not set)';
            } else if ($wall->open_until < date('Y-m-d H:i:s')) {
                $wall->open_until = "Automatically closed ({$wall->open_until})";
            }
        }

        if (empty($walls)) {
            return View::make('session.index')->with('walls', $walls)->with('info', 'No sessions available.');
        } else {
            return View::make('session.index')->with('walls', $walls);
        }
    }

    /**
     * Show the form for creating a new wall.
     *
     * @return Response
     */
    public function create()
    {
        self::updateSpeakers();
        $speakers = User::where('role', 'Speaker')->get();
        return View::make('session.create')->withSpeakers($speakers);
    }

    /**
     * Store a newly created wall in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Server-side validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'speaker' => 'required|exists:users,id,role,Speaker',
            'image' => 'image',
            'password' => 'confirmed',
            'open_until' => 'date',
        ]);

        if ($request->input('password') != null && $request->input('hashtag') != null) {
            $validator->after(function ($validator) {
                $validator->errors()->add('hashtag', 'You can only add a hashtag if the session is not password protected.');
            });
        }

        if ($validator->fails()) {
            return redirect('session/create')
                ->withErrors($validator)
                ->withInput();
        }

        $wall = new Wall;
        $wall->user_id = $request->input('speaker');
        $wall->name = $request->input('name');
        $wall->description = $request->input('description');
        $wall->hashtag = $request->input('hashtag');
        $wall->tags = $request->input('tags');

        if ($request->hasFile('image')) {
            // We need the wall_id
            $wall->save();

            $destinationPath = storage_path() . '/app/wall_images/';
            $fileName = $wall->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destinationPath, $fileName);
        }

        if ($request->has('password')) {
            $wall->password = Hash::make($request->input('password'));
        }

        if ($request->input('open_until') == null) {
            $wall->open_until = null;
        } else {
            $wall->open_until = $request->input('open_until');
        }

        $wall->created_at = new \DateTime();

        $wall->save();

        Session::flash('success', 'Successfully created session.');

        return Redirect::to('session');
    }


    /**
     * Display the specified wall.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $userid = Auth::user()->id; //getfromloggedinuser
        $wall = Wall::findOrFail($id);
        $messages = Message::with("votes", "user")->where("wall_id", "=", $id)->orderBy('created_at', 'desc')->get();
        $polls = Poll::with("choices.votes", "user")->where("wall_id", "=", $id)->orderBy('created_at', 'desc')->get();
        $blacklistedUserIDs = array_column(Blacklist::all('user_id')->toArray(), 'user_id');

        $posts = $this->sortMessagesPollsChronologically($messages, $polls);

        if (count($posts) == 0) {
            return View::make('session.show')
                ->with('wall', $wall)
                ->with("posts", $posts)
                ->with("blacklistedUserIDs", $blacklistedUserIDs)
                ->with('info', 'No messages or polls available on this session');
        }

        return View::make('session.show')
            ->with('wall', $wall)
            ->with('posts', $posts)
            ->with("blacklistedUserIDs", $blacklistedUserIDs);
    }

    /**
     * Display multiple walls.
     *
     * @param  int $id
     * @return Response
     */
    public function showMultiple(Request $request)
    {
        if (!$request->has('beheer') || empty($request->input('beheer'))) {
            return redirect()->back()->with('info', 'Please select atleast one wall.');
        }
        $userid = Auth::user()->id;
        $walls = Wall::whereIn('id', $request->input('beheer'))->get();
        $messages = Message::with("votes", "user")->whereIn("wall_id", $request->input('beheer'))->orderBy('created_at', 'desc')->get();
        $polls = Poll::with("choices.votes", "user")->whereIn("wall_id", $request->input('beheer'))->orderBy('created_at', 'desc')->get();
        $blacklistedUserIDs = Blacklist::all('user_id')->toArray();

        $posts = $this->sortMessagesPollsChronologically($messages, $polls);
        if (count($posts) == 0) {
            return View::make('session.show')
                ->with('walls', $walls)
                ->with('posts', $posts)
                ->with("blacklistedUserIDs", $blacklistedUserIDs)
                ->with('info', 'No messages or polls available on this session');
        }

        return View::make('session.show')
            ->with('walls', $walls)
            ->with('posts', $posts)
            ->with("blacklistedUserIDs", $blacklistedUserIDs);
    }

    private function sortMessagesPollsChronologically($messages, $polls)
    {
      /* Sort messages / poll into a chronologically ordered 2D array */
      $posts = [];

  		if (!$messages->isEmpty())
  		{
  			foreach ($messages as $message)
  			{
  				array_push($posts, array('m', $message));
  			}
  		}
  		else
  		{
  			foreach ($polls as $poll)
  			{
  				array_push($posts, array('p', $poll));
  			}
            return $posts;
  		}

  		$pollCounter = 0;
  		foreach ($polls as $poll)
  		{
  			$append = true;
  			$counter = 0;
  			foreach ($posts as $post)
  			{
  				if ($poll->created_at > $post[1]->created_at)
  				{
  					$arr = array('p', $poll);
  					array_splice($posts, $counter, 0, array($arr));
  					$append = false;
  					break;
  				}
  				$counter += 1;
  			}

  			if ($append)
  			{
  				array_push($posts, array('p', $poll));
  			}

  			$pollCounter += 1;
  		}

  		return $posts;
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

        // Required for datetime-local inputfield
        if ($wall->open_until != null) {
            $old_date_timestamp = strtotime($wall->open_until);
            $wall->open_until = date('Y-m-d H:i', $old_date_timestamp);
            $wall->open_until = str_replace(' ', 'T', $wall->open_until);
        }

        $speakers = User::where('role', 'Speaker')->get();

        $wall->tags = explode(";", $wall->tags);

        return View::make('session.edit')
            ->with('wall', $wall)
            ->withSpeakers($speakers);;
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
        self::updateSpeakers();

        // Server-side validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'speaker' => 'required|exists:users,id,role,Speaker',
            'image' => 'image',
            'password' => 'confirmed',
            'open_until' => 'date',
        ]);

        if ($request->input('password') != null && $request->input('hashtag') != null) {
            $validator->after(function ($validator) {
                $validator->errors()->add('hashtag', 'You can only add a hashtag if the session is not password protected.');
            });
        }

        if ($validator->fails()) {
            return redirect('session/create')
                ->withErrors($validator)
                ->withInput();
        }

        $wall = Wall::find($id);
        $wall->user_id = $request->input('speaker');
        $wall->name = $request->input('name');
        $wall->description = $request->input('description');
        $wall->hashtag = $request->input('hashtag');
        $wall->tags = $request->input('tags');

        if ($request->hasFile('image')) {
            // We need the wall_id
            $wall->save();

            // First check if there was an image uploaded already, if so remove
            $paths = glob(storage_path() . '/app/wall_images/' . $wall->id . '*');
            if (count($paths) != 0) {
                unlink($paths[0]);
            }

            $destinationPath = storage_path() . '/app/wall_images/';
            $fileName = $wall->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destinationPath, $fileName);
        }

        if ($request->has('password')) {
            $wall->password = Hash::make($request->input('password'));
        } else {
            $wall->password = null;
        }

        if ($request->input('open_until') == "")
            $wall->open_until = null;
        else
            $wall->open_until = $request->input('open_until');

        $wall->save();

        Session::flash('success', 'Successfully updated session.');

        return Redirect::to('session');
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

        Session::flash('success', 'Successfully closed the session.');

        return Redirect::to('session');
    }

    /**
     * Add (active) the specified wall to storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function revertDestroy($id)
    {
        $wall = Wall::onlyTrashed()->find($id);
        $wall->restore();

        Session::flash('success', 'Successfully opened the session.');

        return Redirect::to('session');
    }

    public static function updateSpeakers()
    {
        $client = new GuzzleClient();
        $res = $client->get('crm', 'person-get');

        for($i = 0;$i < $res['last_page'];$i++)
		{
            if($i!=0)
            {
                $res = $client->get('crm', 'person-get', ['page'=>$i]);
            }
            foreach ($res['data'] as $user) {
                if (in_array('spreker', $user['roles'])) {
                    $u = new User();
                    if (User::where('email', $user['email'])->first()) {
                        $u = User::where('email', $user['email'])->first();
                    }
                    $u->name = $user['fname'] . ' ' . $user['lname'];
                    $u->role = 'speaker';
                    $u->email = $user['email'];

                    $u->save();
                }
            }
        }
	}
}
