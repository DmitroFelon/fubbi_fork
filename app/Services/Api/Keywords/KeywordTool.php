<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 14/12/17
 * Time: 07:54
 */

namespace App\Services\Api;

use App\Services\Api\Keywords\KeywordsFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use PHPUnit\Runner\Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * Class KeywordTool
 *
 * @package App\Services\Api
 */
class KeywordTool implements KeywordsFactoryInterface
{
	/**
	 * KeywordTool constructor.
	 */
	public function __construct()
	{
		$this->client = new Client(
			[
				'base_uri' => 'https://api.keywordtool.io/v2/',
				'timeout'  => 40,
				'defaults' => [
					'query' => [
						'apikey' => config('keywordtool.apikey'),
					],
				],
			]
		);
	}

	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return \Illuminate\Support\Collection
	 * @throws \Exception
	 */
	public function suggestions($keyword, $country = 'au', $language = 'en') :Collection 
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
			'https://api.keywordtool.io/v2/search/suggestions/google?'.http_build_query($params)
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);

		if (curl_error($ch)) {
			throw new \Exception(curl_error($ch));
		}

		$results = json_decode($output, true);

		if (isset($results['results']) and ! empty($results['results'])) {
			$results = (isset($results['results'])) ? collect($results['results']) : collect();

			$results = $results->collapse();

			$keywords = collect($results->keyBy('string'));

			$keywords->transform(
				function ($item, $key) {
					return false;
				}
			);

			return $keywords;
		}

		throw new \Exception(\GuzzleHttp\json_encode($output));
	}

	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return \Illuminate\Support\Collection
	 */
	public function questions($keyword, $country = 'au', $language = 'en'):Collection
	{
		return collect();
	}

}
