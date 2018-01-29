<?php

namespace App\Http\Controllers;

use App\Services\Api\Keywords\KeywordsFactoryInterface;
use App\Services\Api\KeywordTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResearchController extends Controller
{


    public function index()
    {
        return view('entity.research.index');
    }

    /**
     * @param \App\Services\Api\Keywords\KeywordsFactoryInterface $api
     * @return string
     */
    public function load(Request $request, KeywordsFactoryInterface $api)
    {
        $theme = ($request->has('theme'))
            ? trim($request->input('theme'))
            : null;

        $source = ($request->has('source'))
            ? trim($request->input('source'))
            : KeywordTool::SOURCE_GOOGLE;

        $country = ($request->has('country'))
            ? $request->input('country')
            : 'au';

        $language = 'en';

        if (strlen($country) > 2) {
            $countries = config('fubbi.countries', []);
            $key       = array_search($country, $countries);
            $country   = ($key)
                ? $key
                : 'au';
        }

        $metrics = 'googlesearchnetwork';

        $key = 'questions.' . $theme . '.' . $country . '.' . $language . '.' . $metrics . '.' . $source;

        $questions = Cache::remember($key, 60 * 24, function () use ($api, $theme, $country, $language, $metrics, $source) {
            return $api->questions($theme, $country, $language, $metrics, $source);
        });

        $key = 'suggestions.' . $theme . '.' . $country . '.' . $language . '.' . $metrics . '.' . $source;

        $suggestions = Cache::remember($key, 60 * 24, function () use ($api, $theme, $country, $language, $metrics, $source) {
            return $api->suggestions($theme, $country, $language, $metrics, $source);
        });

        $title = KeywordTool::getSourceName($source);

        return view('entity.research.partials.result', compact('title', 'questions', 'suggestions'));
    }
}
