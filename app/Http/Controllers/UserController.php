<?php

namespace App\Http\Controllers;

use App\Models\Helpers\ProjectStates;
use App\Models\Role;
use App\Services\User\SearchSuggestions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * ProjectController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('can:index,' . User::class)->only(['index']);
        $this->middleware('can:view,user')->only(['show']);
        //c$this->middleware('can:create,user')->only(['create', 'store']);
        $this->middleware('can:update,user')->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get roles
        $roles = Cache::remember(
            'role_names',
            10,
            function () {
                return Role::all();
            }
        );

        //process search
        if ($this->request->input('s')) {
            $users = User::search($this->request->input('s'))->get();
        } else {
            $users = User::all();
        }

        $users = $users->filter(function (User $user) {
            return isset($user->role);
        });

        $search_suggestions = SearchSuggestions::toView();

        //separate users by roles
        $groupedByRoles = $users->groupBy('role');

        //fill emprty roles by emprty collection
        foreach ($roles as $role) {
            $groupedByRoles[$role->name] = (isset($groupedByRoles[$role->name])) ? $groupedByRoles[$role->name]
                : collect();
        }

        return view('entity.user.index', compact('users', 'groupedByRoles', 'roles', 'search_suggestions'));
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
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|integer'
        ]);


        $user->fill($request->input());
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->roles()->attach($request->input('role'));
        $user->save();

        Cache::set('temp_password_' . $user->id, $request->input('password'));

        return redirect()->action('UserController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
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

            return redirect()
                ->action('ProjectController@edit', [
                    $last_project,
                    's' => ProjectStates::QUIZ_FILLING
                ])
                ->with('success', _i('Please, fill the quiz.'));
        }

        return redirect()->back()->with('success', _i('Profile has been saved successfully'));

    }

}
