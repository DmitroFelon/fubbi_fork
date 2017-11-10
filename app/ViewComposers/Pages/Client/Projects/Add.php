<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 07/11/17
 * Time: 12:11
 */

namespace App\ViewComposers\Pages\Client\Projects;

use App\Models\Keyword;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Class Add
 *
 * @package App\ViewComposers\Pages\Client\Projects
 */
class Add
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $user;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = Auth::user();
    }

    /**
     * @param \Illuminate\View\View $view
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function compose(View $view)
    {
        $id = $this->request->route('id');

        if (is_null($id)) {
            $project = new Project();
            $project->client_id = $this->user->id;
            $project->name = '';
            $project->description = '';
            $project->state = Project::CREATED;
            $project->save();
            $id = $project->id;
            return redirect('/projects/add/'.$id);
        } else {
            $project = Project::find($id);
        }

        if (! $project instanceof Project) {
            abort(404);
        }

        if($project->client_id != $this->user->id){
            abort(404);
        }

        $keywords = Cache::remember('keywords', Carbon::now()->addMinutes(10), function () {
            return Keyword::groupBy('text')->get();
        });

        $view->with('keywords', $keywords->toArray());

        $view->with('project', $project);
    }
}