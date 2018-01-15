<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 14/12/17
 * Time: 07:54
 */

namespace App\Services\Api;

use App\Services\Api\Keywords\KeywordsFactoryInterface;
use Illuminate\Support\Collection;

/**
 * Class KeywordTool
 *
 * @package App\Services\Api
 */
class KeywordTool implements KeywordsFactoryInterface
{

    const SOURCE_GOOGLE    = 'google';
    const SOURCE_youtube   = 'youtube';
    const SOURCE_bing      = 'bing';
    const SOURCE_AMAZON    = 'amazon';
    const SOURCE_EBAY      = 'ebay';
    const SOURCE_APP_STORE = 'app-store';

    /**
     * @param $keyword
     * @param string $country
     * @param string $language
     * @param string $metrics
     * @return Collection
     * @throws \Exception
     */
    public function suggestions($keyword, $country = 'au', $language = 'en', $metrics = 'googlesearchnetwork'):Collection
    {
        $apikey = config('keywordtool.apikey');

        $params = [
            'apikey'          => $apikey,
            'keyword'         => urldecode($keyword),
            'country'         => $country,
            'language'        => $language,
            'metrics_network' => 'googlesearchnetwork',
            'output'          => 'json',
        ];

        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            sprintf("https://api.keywordtool.io/v2/search/suggestions/%s?%s", self::SOURCE_GOOGLE, http_build_query($params))
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if (curl_error($ch)) {
            throw new \Exception(curl_error($ch));
        }

        $results = json_decode($output, true);

        if (isset($results['results']) and !empty($results['results'])) {
            $results  = (isset($results['results'])) ? collect($results['results']) : collect();
            $results  = $results->collapse();
            $keywords = collect($results->keyBy('string'));
            $keywords->transform(
                function ($item, $key) {
                    //set each $keyword => false
                    return false;
                }
            );
            return $keywords;
        }

        throw new \Exception(json_encode($output));
    }

    /**
     * @param $keyword
     * @param string $country
     * @param string $language
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function questions($keyword, $country = 'au', $language = 'en', $metrics = 'googlesearchnetwork'):Collection
    {
        $apikey = config('keywordtool.apikey');

        $params = [
            'apikey'          => $apikey,
            'keyword'         => urldecode($keyword),
            'country'         => $country,
            'language'        => $language,
            'metrics_network' => 'googlesearchnetwork',
            'output'          => 'json',
            'type'            => 'questions'
        ];

        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            sprintf("https://api.keywordtool.io/v2/search/suggestions/%s?%s", self::SOURCE_GOOGLE, http_build_query($params))
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if (curl_error($ch)) {
            throw new \Exception(curl_error($ch));
        }

        $results = json_decode($output, true);

        if (isset($results['results']) and !empty($results['results'])) {
            $results = (isset($results['results'])) ? collect($results['results']) : collect();

            $categories_count = $results->count();
            $results          = $results->collapse();
            //remove sub categories from result
            $results  = $results->slice($categories_count);
            $keywords = collect($results->keyBy('string'));
            $keywords->transform(
                function ($item, $key) {
                    return false;
                }
            );
            return $keywords;
        }

        throw new \Exception(json_encode($output));
    }

}
