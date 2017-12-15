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
use PHPUnit\Runner\Exception;
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

	public function test($keyword){
		$apikey = config('keywordtool.apikey');

		$params = array(
			'apikey' => $apikey,
			'keyword' => $keyword,
			'metrics_network' => 'googlesearchnetwork',
			'output' => 'json',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.keywordtool.io/v2/search/suggestions/google?' . http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$output = curl_exec($ch);
		return json_decode($output, TRUE);
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
			'apikey'  => config('keywordtool.apikey'),
			'keyword' => trim($keyword),
		];
		try {
			$response = $this->request('search/suggestions/google', $body);

			return $this->response($response);
		} catch (RequestException $e) {
			throw $e;
		} catch (\Exception $e) {
			throw $e;
		}
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
				(!isset($body['results']) or (empty($body['results']))),
				new \Exception("KeywordTool returns an error: {$notice}, response: ".json_encode($response))
			);

			return collect($body['results']);
		} catch (Exception $e) {
			throw $e;
		}
	}
}
