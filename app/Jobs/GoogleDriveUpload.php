<?php

namespace App\Jobs;

use App\Services\Google\Drive;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GoogleDriveUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $file;


    /**
     * Create a new job instance.
     *
     * @param $project
     * @param $file
     * @internal param $folder
     */
    public function __construct($project, $file)
    {
        $this->project = $project;

        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @param Drive $google
     */
    public function handle(Drive $google)
    {

    }


    private function composePath()
    {
        $google_docs_folders = [
            $this->project->client->name,
            $this->project->name,
            Carbon::now()->format('Y'),
            Carbon::now()->format('F'),
        ];

        return $google_docs_folders;
    }

    private function isPathExist()
    {

    }

    private function createPath(array $path){
        
    }
}
