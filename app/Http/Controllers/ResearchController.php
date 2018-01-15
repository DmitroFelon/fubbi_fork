<?php

namespace App\Http\Controllers;

use App\Services\Api\Keywords\KeywordsFactoryInterface;
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

        $country = ($request->has('country'))
            ? $request->input('country')
            : 'au';

        $language = ($request->has('language'))
            ? $request->input('language')
            : 'en';


        if (strlen($country) > 2) {
            $countries = config('fubbi.countries', []);
            $key       = array_search($country, $countries);
            $country   = ($key)
                ? $key
                : 'au';
        }

        $metrics = ($request->has('metrics'))
            ? $request->input('metrics')
            : 'googlesearchnetwork';


        $questions = Cache::remember('questions.' . $theme . '.' . $country . '.' . $language . '.' . $metrics, 60 * 24, function () use ($api, $theme, $country, $language, $metrics) {
            return $api->questions($theme, $country, $language, $metrics);
        });

        $suggestions = Cache::remember('suggestions.' . $theme . '.' . $country . '.' . $language . '.' . $metrics, 60 * 24, function () use ($api, $theme, $country, $language, $metrics) {
            return $api->suggestions($theme, $country, $language, $metrics);
        });

        return view('entity.research.partials.result', compact('questions', 'suggestions'));

    }
}
