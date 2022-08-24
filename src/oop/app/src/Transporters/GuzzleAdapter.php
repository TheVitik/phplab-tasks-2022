<?php

namespace src\oop\app\src\Transporters;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleAdapter implements TransportInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function getContent(string $url): string
    {
        $response = $this->client->request('GET', $url);
        if ($response->getStatusCode() != 200) {
            throw new Exception('Request error', $response->getStatusCode());
        }

        return $response->getBody();
    }
}
