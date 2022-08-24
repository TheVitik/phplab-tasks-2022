<?php

namespace src\oop\app\src\Transporters;

use Exception;

class CurlStrategy implements TransportInterface
{
    /**
     * @throws Exception
     */
    public function getContent(string $url): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/81.0');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

        $data = curl_exec($curl);
        if ($data === false) {
            throw new Exception(curl_error($curl));
        }

        return $data;
    }
}
