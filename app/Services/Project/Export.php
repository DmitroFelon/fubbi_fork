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

class Export
{

    public static function make(Project $project) : string
    {
        $data        = [];
        $collections = $project->media->groupBy('collection_name')->keys();
        //collect media files
        foreach ($collections as $collection) {
            $collection_files = $project->getMedia($collection);
            if (strpos($collection, 'meta-') !== false) {
                if ($collection_files->isNotEmpty()) {
                    $collection_files->each(function (Media $item) use (&$data, $collection) {
                        $collection = str_replace('meta-', '', $collection);
                        $collection = str_replace('-collection', '', $collection);
                        $collection = str_replace('-', ' ', $collection);
                        $collection = str_replace('_', ' ', $collection);

                        if (File::exists($item->getPath())) {
                            $data['keywords_media'][$collection][] = $item->getPath();
                        }

                    });
                }
            } else {
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
        }

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

        $pdf     = App::make('dompdf.wrapper');
        $project = $project;
        $pdf     = $pdf->loadView('pdf.export', compact('meta', 'project'));

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

        if (isset($data['keywords_media'])) {
            foreach ($data['keywords_media'] as $collection => $files) {
                $zipper->folder($main_folder . '/keywords media/' . $collection)->add($files);
            }
        }

        $zipper->close();

        //save path to zip to metadata
        $project->setMeta('export', $zip_name);
        $project->save();

        return $full_path;
    }

}