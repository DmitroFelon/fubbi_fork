<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Api\Keywords\KeywordsFactoryInterface;
use Illuminate\Support\Facades\Session;

/**
 * Class KeywordsController
 *
 * @package App\Http\Controllers
 */
class KeywordsController extends Controller
{
    /**
     * @param \App\Models\Project $project
     * @param string $theme
     * @param \App\Services\Api\Keywords\KeywordsFactoryInterface $api
     * @return string
     */
    public function index(Project $project, string $theme, KeywordsFactoryInterface $api)
    {
        $max_count = config('fubbi.keywords_count');

        try {
            $keywords_full = ($project->getMeta('keywords')) ? collect($project->getMeta('keywords')) : collect();

            if ($keywords_full->has($theme) and !empty($keywords_full->get($theme))) {
                // get from database if exist
                $keywords = collect($keywords_full->get($theme));
                if ($keywords->count() > $max_count) {
                    $keywords->shuffle();
                    $keywords = $keywords->take($max_count);
                    $test = '';
                }
            } else {
                // load from api,
                // "KeywordTool" by default
                $keywords = $api->suggestions($theme);


                /*
                                if ($keywords->count() > config('fubbi.keywords_count')) {
                                    $keywords = $keywords->random(config('fubbi.keywords_count'));
                                }*/

                $keywords_full->put($theme, $keywords->toArray());

                $project->setMeta('keywords', $keywords_full);

                $project->save();
            }

            $data = [
                'project' => $project,
                'keywords' => $keywords,
                'theme' => $theme,
            ];

            return view('entity.project.partials.form.keywords-step', $data);
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
}
