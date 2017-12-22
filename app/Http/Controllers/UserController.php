<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
            60 * 60 * 60,
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

        $search_suggestions = $this->searchSuggestions();

        //separate users by roles
        $groupedByRoles = $users->groupBy('role');

        //fill emprty roles by emprty collection
        foreach ($roles as $role) {
            $groupedByRoles[$role->name] = (isset($groupedByRoles[$role->name])) ? $groupedByRoles[$role->name] : collect();
        }

        return view('entity.user.index', compact(['users', 'groupedByRoles', 'roles', 'search_suggestions']));
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
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|integer'
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
            'phone' => 'required',
            'password' => 'sometimes|nullable|confirmed|min:6',
        ]);

        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->phone = $request->input('phone');

        $user->save();


        return redirect()->back()->with('success', _i('Profile has been saved successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function searchSuggestions()
    {
        return Cache::remember(
            'user_search_suggestions',
            10,
            function () {
                $search_suggestions = collect();
                User::all()->map(
                    function (User $user) use ($search_suggestions) {
                        $search_suggestions->push($user->name);
                        $search_suggestions->push($user->email);
                    }
                );
                $search_suggestions = $search_suggestions->toArray();

                return '["' . implode('", "', $search_suggestions) . '"]';
            }
        );
    }
}
