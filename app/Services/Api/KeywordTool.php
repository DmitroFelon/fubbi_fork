<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 14/12/17
 * Time: 07:54
 */

namespace App\Services\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class KeywordTool
 *
 * @package App\Services\Api
 */
class KeywordTool
{
	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

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
	 * @param array $keywords
	 * @param string $country
	 * @param string $language
	 * @return mixed
	 */
	public function volume(array $keywords, $country = 'au', $language = 'en')
	{

		$body = [
			'apikey'           => config('keywordtool.apikey'),
			'keyword'          => json_encode($keywords),
			'metrics_language' => $language,
			'metrics_network'  => 'googlesearchnetwork',
			'country'          => $country,
			'output'           => 'json',
		];

		$response = $this->request('search/volume/google', $body);

		return $this->response($response);
	}

	/**
	 * @param $uri
	 * @param $body
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 */
	private function request($uri, $body)
	{
		try {
			return $this->client->request(
				'GET',
				$uri,
				['query' => $body]
			);
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

		$body   = json_decode($response->getBody()->getContents(), true);
		$notice = isset($body['notice']['message']) ? $body['notice']['message'] : '';

		throw_unless(
			(isset($body['results']) or !(empty($body['results'] ))),
			new \Exception("KeywordTool returns an error: {$notice}")
		);

		return collect($body['results']);
	}

	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return \Illuminate\Support\Collection
	 */
	public function suggestions($keyword, $country = 'au', $language = 'en')
	{

		$body = [
			'apikey'           => config('keywordtool.apikey'),
			'keyword'          => $keyword,
			'metrics_language' => $language,
			'metrics_network'  => 'googlesearchnetwork',
			'country'          => $country,
			'output'           => 'json',
			'complete'         => true,
			'type'             => 'suggestions',
		];
		try {
			return $this->response(
				$this->request('search/suggestions/google', $body)
			);
		} catch (RequestException $e) {
			throw $e;
		}
	}

	/**
	 * @param $keyword
	 * @param string $country
	 * @param string $language
	 * @return mixed
	 */
	public function questions($keyword, $country = 'au', $language = 'en')
	{
		$body = [
			'apikey'           => config('keywordtool.apikey'),
			'keyword'          => $keyword,
			'metrics_language' => $language,
			'metrics_network'  => 'googlesearchnetwork',
			'country'          => $country,
			'output'           => 'json',
			'type'             => 'questions',
		];

		try {
			return $this->response(
				$this->request('search/suggestions/google', $body)
			);
		} catch (RequestException $e) {
			throw $e;
		}
	}
}
