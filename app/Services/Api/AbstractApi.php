<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 13:57
 */

namespace App\Services\Api;

use Exception;
use GuzzleHttp\Client;

class AbstractApi
{
	protected $client;

	public function __construct($base_uri, $defaults)
	{
		$this->client = new Client(
			[
				'base_uri' => $base_uri,
				'timeout'  => 2.0,
				$defaults
			]
		);
	}

	public function request($uri, $params = [], $method = 'GET')
	{
		try {
			$this->client->request($method, $uri, [
				'query' => ['foo' => 'bar']
			]);
		} catch (Exception $e) {
		}
	}
}