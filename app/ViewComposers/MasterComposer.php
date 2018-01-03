<?php


namespace App\ViewComposers;

use App\Models\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Musonza\Chat\Chat;
use Musonza\Chat\Messages\Message;
use Musonza\Chat\Notifications\MessageSent;

/**
 * Class MasterComposer
 * @package App\ViewComposers
 */
class MasterComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * @var string
     */
    protected $page;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->page    = $request->path();
        $this->user    = Auth::user();
        $this->request = $request;
    }

    /**
     * @param View $view
     * @return $this|void
     */
    public function compose(View $view)
    {
        if ($this->request->ajax()) {
            return;
        }

        if (!Auth::check()) {
            return;
        }

        $data = [
            'notifications'         => $this->user->getNotifications(),
            'message_notifications' => $this->user->getMessageNotifications(),
            'help_video_src'        => $this->helpVideoSrc()
        ];

        return $view->with($data);
    }

    /**
     * @return bool|string
     */
    public function helpVideoSrc()
    {
        if ($this->request->is('projects')) {
            return config('fubbi.videos.project.main');
        }

        if ($this->request->is('projects/create')) {
            return config('fubbi.videos.project.create');
        }

        if ($this->request->is('projects/*/edit') and $this->request->has('s')) {
            if ($this->request->get('s') == 'plan') {
                return config('fubbi.videos.project.edit.plan');
            }

            if ($this->request->get('s') == 'quiz') {
                return config('fubbi.videos.project.edit.quiz');
            }

            if ($this->request->get('s') == 'keywords') {
                return config('fubbi.videos.project.edit.keywords');
            }
        }

        return false;
    }
}