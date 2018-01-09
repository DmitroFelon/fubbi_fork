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
            $keywords_full           = ($project->getMeta('keywords'))
                ? collect($project->getMeta('keywords'))
                : collect();
            
            $keywords_questions_full = ($project->getMeta('keywords_questions'))
                ? collect($project->getMeta('keywords_questions'))
                : collect();

            //get keywords for theme
            $theme = trim($theme);
            if ($keywords_full->has($theme) and !empty($keywords_full->get($theme))) {
                // get from database if exist
                $keywords = collect($keywords_full->get($theme));
            } else {
                // load from api,
                // "KeywordTool" by default
                $keywords = $api->suggestions($theme);

                if ($keywords->count() > $max_count) {
                    $keywords->shuffle();
                    $keywords = $keywords->take($max_count);
                }

                $keywords_full->put($theme, $keywords->toArray());
                $project->setMeta('keywords', $keywords_full);
                $project->save();
            }

            //get keywords for questions
            if ($keywords_questions_full->has($theme) and !empty($keywords_questions_full->get($theme))) {
                // get from database if exist
                $keywords_questions = collect($keywords_questions_full->get($theme));
            } else {
                // load from api,
                // "KeywordTool" by default
                $keywords_questions = $api->questions($theme);

                if ($keywords_questions->count() > $max_count) {
                    $keywords_questions->shuffle();
                    $keywords_questions = $keywords_questions->take($max_count);
                }

                $keywords_questions_full->put($theme, $keywords_questions->toArray());
                $project->setMeta('keywords_questions', $keywords_questions_full);
                $project->save();
            }

            $keywords_meta = $project->getMeta('keywords_meta');
            

            $meta = (isset($keywords_meta[$theme]))
                ? collect($keywords_meta[$theme])
                : collect();


            return view('entity.project.partials.form.keywords-step', compact('project', 'keywords', 'keywords_questions', 'theme', 'meta'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
}
