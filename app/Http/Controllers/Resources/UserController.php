<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Helpers\ProjectStates;
use App\Models\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserController
 * @package App\Http\Controllers\Resources
 */
class UserController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * @var User
     */
    protected $user;

    /**
     * ProjectController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->middleware('can:index,' . User::class)->only(['index']);
        //$this->middleware('can:show')->only(['show']);
        //c$this->middleware('can:create,user')->only(['create', 'store']);
        $this->middleware('can:update,user')->only(['edit', 'update']);
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->withTrashed()->get();

        return view('entity.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entity.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|unique:users,email',
            'phone'      => 'required',
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|integer'
        ]);

        try {
            $user->fill($request->input());
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $user->roles()->attach($request->input('role'));
            $user->save();

            if ($request->has('team') and $request->input('team') > 0) {
                $team = Team::find($request->input('team'));

                if ($team) {
                    $user->teams()->attach($team);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Something wrong happened while user creation. Try again, please.');
        }

        Cache::set('temp_password_' . $user->id, $request->input('password'));


        return redirect()->action('Resources\UserController@index')
                         ->with('success', 'User has been created successully');

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function show($id)
    {
        $user = $this->user->withTrashed()->findOrFail($id);
        return view('entity.user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('entity.user.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'phone'    => 'required',
            'password' => 'sometimes|nullable|confirmed|min:6',
        ]);

        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->phone               = $request->input('phone');
        $user->address_line_1      = $request->input('address_line_1');
        $user->address_line_2      = $request->input('address_line_2');
        $user->zip                 = $request->input('zip');
        $user->city                = $request->input('city');
        $user->country             = $request->input('country');
        $user->state               = $request->input('state');
        $user->how_did_you_find_us = $request->input('how_did_you_find_us');

        $user->save();

        if ($request->has('redirect_to_last_project')) {
            $last_project = $user->projects()->latest('id')->first();

            if ($last_project) {
                return redirect()
                    ->action('Resources\ProjectController@edit', [
                        $last_project,
                        's' => ProjectStates::QUIZ_FILLING
                    ])
                    ->with('success', _i('Please, fill the quiz.'));
            }
        }

        return redirect()->back()->with('success', _i('Profile has been saved successfully'));

    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {

        if (Auth::user()->id == $id) {
            return redirect()->back()->with('error', "You can't block yourself");
        }

        $user = $this->user->withTrashed()->find($id);

        if ($user->trashed()) {
            $user->restore();
            return redirect()->back()->with('success', $user->name . ' has been restored');
        }

        $user->delete();
        return redirect()->back()->with('error', $user->name . ' has been blocked');

    }
}
