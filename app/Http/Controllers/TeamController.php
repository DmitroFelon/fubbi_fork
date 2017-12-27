<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
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

        $user = $this->request->user();

        switch ($user->role) {
            case 'admin':
                $teams = Team::with('users')->get();

                break;
            case 'client':
                $teams = $user->teams()->with('users')->get();
                if ($teams->isEmpty()) {
                    return redirect()->action('ProjectController@create');
                }
                break;
            default:
                $teams = $user->teams()->with('users')->get();

                break;
        }

        return view('entity.team.index', ['teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users = User::without(['notifications', 'invites'])->get(['id', 'first_name', 'last_name', 'email']);

        $users = $users->keyBy('id')->transform(function (User $user) {
            if ($user->role == 'client') {
                return null;
            }
            return $user->name;
        })->filter();

        $data = [
            'owner_users' => $users,
            'invitable_users' => $users,
        ];


        return view('entity.team.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Team $team)
    {
        $team->fill($request->except(['_token']));
        $team->save();


        if ($request->has('users')) {
            $users = User::whereIn('id', $request->input('users'));
            $users->each(function (User $user) use ($team) {
                $user->inviteTo($team);
            });
        }

        return redirect()->action('TeamController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('entity.team.show', ['team' => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $users = User::without(['notifications', 'invites'])->get(['id', 'first_name', 'last_name', 'email']);

        $owner_users = $users->keyBy('id')->transform(function (User $user) {
            if ($user->role == 'client') {
                return null;
            }
            return $user->name;
        });

        $invitable_users = $users->keyBy('id')->transform(function (User $user) use ($team) {
            if ($user->role == 'client') {
                return null;
            }

            if ($user->hasInvitetoTeam($team->id)) {
                return null;
            }

            if (in_array($user->id, $team->users->pluck('id')->toArray())) {
                return null;
            }

            if ($user->id == $team->owner_id) {
                return null;
            }

            return $user->name;
        });

        $data = [
            'team' => $team,
            'owner_users' => $owner_users->filter(),
            'invitable_users' => $invitable_users->filter(),
        ];

        return view('entity.team.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $team->fill(
            $request->except(['_method', '_token'])
        );

        $team->save();

        if ($request->has('users')) {
            $ids   = array_keys($request->input('users'));
            $users = User::whereIn('id', $ids)->get();
            $users->each(function (User $user) use ($team) {
                $user->inviteTo($team);
            });
        }

        return redirect()->action('TeamController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    public function accept(Team $team)
    {
        $user = Auth::user();

        $team->users()->attach($user->id);

        $invite = $user->getInviteToTeam($team->id);
        $invite->accept();

        return redirect()->back()->with('success', _i('Now You are a part of this team'));
    }

    public function decline(Team $team)
    {
        $user = Auth::user();

        $invite = $user->getInviteToTeam($team->id);

        $invite->decline();

        return redirect()->back()->with('info', _i('Invitation has beed declined'));
    }
}
