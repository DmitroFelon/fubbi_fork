<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/26/18
 * Time: 1:29 PM
 */

namespace App\Services\Project;


use App;
use App\Models\Project;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\Media;

/**
 * Class Export
 * @package App\Services\Project
 */
class Export
{

    /**
     * @param Project $project
     * @return string
     */
    public function make(Project $project) : string
    {
        $data        = [];
        $collections = $project->media->groupBy('collection_name')->keys();
        //collect media files
        foreach ($collections as $collection) {
            $collection_files = $project->getMedia($collection);
            if ($collection_files->isNotEmpty()) {
                $collection_files->each(function (Media $item) use (&$data, $collection) {
                    $collection = str_replace('-', ' ', $collection);
                    $collection = str_replace('_', ' ', $collection);

                    if (File::exists($item->getPath())) {
                        $data['media'][$collection][] = $item->getPath();
                    }

                });
            }
        }

        $project->ideas->each(function (App\Models\Idea $idea) use (&$data) {
            $idea->getMedia()->each(function (Media $item) use (&$data, $idea) {
                if (File::exists($item->getPath())) {
                    $data['themes_media'][str_replace('-', ' ', $idea->theme)][] = $item->getPath();
                }
            });
        });


        $meta = $project->getMeta();
        $skip = [
            'quora_username',
            'quora_password',
            'keywords',
            'questions',
            'themes',
            'themes_order',
            'conversation_id',
            'keywords_questions',
            'keywords_meta',
            'seo_first_name',
            'seo_last_name',
            'seo_email',
            'google_access',
            'export',
            'plan'
        ];
        $meta = $meta->filter(function ($item, $key) use ($skip) {
            if (strpos($key, 'modificator_') !== false) {
                return null;
            }
            if (in_array($key, $skip)) {
                return null;
            }
            return $item;
        });
        $meta = $meta->filter();

        try {
            //$pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('pdf.export', compact('meta', 'project'));
        } catch (\Exception $e) {
            throw $e;
        }

        //zip everything
        $path        = storage_path('app/public/exports/');
        $zipper      = new \Chumper\Zipper\Zipper;
        $main_folder = 'project - ' . $project->name;
        $zip_name    = $project->name . '-' . $project->id . '.zip';
        $full_path   = $path . $zip_name;
        $pdf_path    = $path . $project->name . '-' . $project->id . '.pdf';
        $pdf->save($pdf_path);
        $zipper->make($full_path)->folder($main_folder)->add($pdf_path);

        //set media
        if (isset($data['media'])) {
            foreach ($data['media'] as $collection => $files) {
                $zipper->folder($main_folder . '/' . $collection)->add($files);
            }
        }

        if (isset($data['themes_media'])) {
            foreach ($data['themes_media'] as $subfolder => $files) {
                $zipper->folder($main_folder . '/themes media/' . $subfolder)->add($files);
            }
        }

        $zipper->close();

        //save path to zip to metadata
        $project->setMeta('export', $zip_name);
        $project->save();

        return $full_path;
    }

}