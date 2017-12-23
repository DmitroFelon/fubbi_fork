<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Project;
use App\Services\Google\Drive;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Media;

/**
 * Class GoogleDriveUpload
 * @package App\Jobs
 */
class GoogleDriveUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    protected $project;
    /**
     * @var Article
     */
    protected $article;
    /**
     * @var Media
     */
    protected $file;
    /**
     * @var null
     */
    protected $name;
    /**
     * @var Drive
     */
    protected $drive;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     * @param Article $article
     * @param Media $file
     * @param null $name
     */
    public function __construct(Project $project, Article $article, Media $file, $name)
    {
        $this->project = $project;
        $this->article = $article;
        $this->file    = $file;
        $this->name    = $name;
        $this->drive   = new Drive();
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {

        try {
            $expected_path = $this->composePath();

            //get the top folder
            $file_parent = last($this->createPath($expected_path));

            $file = $this->drive->uploadFile(
                $this->file->getPath(),
                $this->name,
                $file_parent
            );


            $this->article->google_id = $file->id;
            $this->article->save();

            $permissions = $this->createPermissions();

            $this->drive->addPermission($file_parent, $permissions->toArray());

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }


    /**
     * @return array
     */
    private function composePath()
    {
        $client_name        = $this->project->client->name;
        $project_name       = $this->project->name;
        $subscription_year  = $this->project->subscription->updated_at->format('Y');
        $subscription_month = $this->project->subscription->updated_at->format('F');


        $google_docs_folders = [
            $client_name,
            implode(' - ', [$client_name, $project_name]),
            implode(' - ', [$client_name, $project_name, $subscription_year]),
            implode(' - ', [$client_name, $project_name, $subscription_year, $subscription_month]),
        ];

        return $google_docs_folders;
    }

    /**
     * @param array $path
     * @return array
     * @throws \Exception
     */
    private function createPath(array $path)
    {
        //check is path exist recursively
        $result = $this->drive->isPathExist($path);

        $next_parent = null;

        $result_striped = [];

        //remove "response-" from batch item name
        foreach ($result as $item => $exist) {
            $name                  = strval(str_replace('response-', '', $item));
            $result_striped[$name] = $exist;
        }

        $result = $result_striped;

        //create necessary folders
        foreach ($result as $folder_name => $exist) {

            $folder_id = ($exist)
                ? $exist
                : $this->drive->addFolder($folder_name, $next_parent)->id;

            $result[$folder_name] = $folder_id;

            $next_parent = $folder_id;
        }

        //return folders' ids
        return array_values($result);
    }

    private function createPermissions()
    {
        $permissions = collect();

        //set article uploader as owner
        $permissions->put($this->article->author->email, 'writer');
        //set project client as commenter
        $permissions->put($this->project->client->email, 'commenter');

        //set other workers as writer
        $this->project->workers->each(function (User $worker) use ($permissions) {
            if ($worker->email == $this->article->author->email) {
                return;
            }
            $permissions->put($worker->email, 'writer');
        });

        $admins = User::withRole('admin')->get();

        //set admins as reader
        $admins->each(function (User $admin) use ($permissions) {
            if ($admin->email == $this->article->author->email) {
                return;
            }
            $permissions->put($admin->email, 'commenter');
        });

        return $permissions;
    }
}
