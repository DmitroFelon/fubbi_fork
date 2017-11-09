<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 07/11/17
 * Time: 12:11
 */

namespace App\ViewComposers\Pages\Client\Projects;

use App\Models\Keyword;
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
     */
    public function compose(View $view)
    {

        $user = $this->user;

        $projects = Cache::remember('projects-user-'.$user->id, Carbon::now()->addMinutes(10), function () use ($user) {
            return $user->projects()->with('workers')->get();
        });
        
        $keywords = Cache::remember('keywords', Carbon::now()->addMinutes(10), function () {
            return Keyword::groupBy('text')->get();
        });

        $view->with('projects', $projects);
        $view->with('keywords', $keywords);
    }
}