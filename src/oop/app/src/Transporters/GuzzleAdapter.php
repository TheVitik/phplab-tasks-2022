<?php

namespace src\oop\app\src\Transporters;

use Exception;
use GuzzleHttp\Client;

class GuzzleAdapter implements TransportInterface
{

    /**
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContent(string $url): string
    {
        $client = new Client();
        $response = $client->request('GET', $url);
        if ($response->getStatusCode() != 200) {
            throw new Exception('Request error');
        }

        return $response->getBody();
    }
}