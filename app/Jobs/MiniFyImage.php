<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\Media;

class MiniFyImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $media;

    /**
     * Create a new job instance.
     *
     * @param Media $media
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $image = Image::make($this->media->getPath());

            File::makeDirectory('storage/' . $this->media->id . '/dropzone/', 0777, true, true);

            $image->fit(120, 120)
                  ->save(public_path('storage/' . $this->media->id . '/dropzone/' . $this->media->file_name));

            Log::debug($image->basePath() . PHP_EOL);

            $image->destroy();
        } catch (\Exception $e) {
            Log::error(json_encode($e->getMessage()));
        }
    }
}
