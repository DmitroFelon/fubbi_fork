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
	 * @return mixed
	 * @throws \Exception
	 */
	public function test2($keyword)
	{
		$params = [
			'cx'     => '014431535617793814068:kmrzg_w7iqo',
			'key'    => 'AIzaSyAzD1oduAfxtYOf4y1Jc9KON_DkrgbT99U',
			'q'      => $keyword,
			'gl'     => 'au',
			'fields' => 'items(title)',
			'number' => 20,
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1?'.http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);

		if (curl_error($ch)) {
			throw new \Exception(curl_error($ch));
		}

		$results = json_decode($output, true);

		$results['results'] = $results['items'];

		unset($results['items']);

		return $results;
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

	/**
	 * @param $uri
	 * @param $body
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 */
	private function request($uri, $body)
	{
		try {
			return $this->client->request('GET', $uri, ['query' => $body]);
		} catch (RequestException $e) {
			throw $e;
		}
	}

	/**
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @return \Illuminate\Support\Collection
	 */
	private function response(ResponseInterface $response)
	{
		try {

			$body = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

			$notice = isset($body['notice']['message']) ? $body['notice']['message'] : '';

			throw_if(
				(! isset($body['results']) or (empty($body['results']))),
				new \Exception("KeywordTool returns an error: {$notice}, response: ".json_encode($response))
			);

			return collect($body['results']);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
