<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 13:57
 */

namespace App\Services\Api;

use GuzzleHttp\Client;

class AbstractApi
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}