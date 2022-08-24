<?php

namespace src\oop\app\src;

use src\oop\app\src\Parsers\KinoukrDomCrawlerParserAdapter;
use src\oop\app\src\Parsers\FilmixParserStrategy;
use src\oop\app\src\Transporters\CurlStrategy;
use src\oop\app\src\Transporters\GuzzleAdapter;
use Exception;

class ScrapperFactory
{
    /**
     * @return Scrapper
     * @throws Exception
     */
    public function create(string $domain): Scrapper
    {
        return match ($domain) {
            'filmix' => new Scrapper(new CurlStrategy(), new FilmixParserStrategy()),
            'kinoukr' => new Scrapper(new GuzzleAdapter(), new KinoukrDomCrawlerParserAdapter()),
            default => throw new Exception('Resource not found!'),
        };
    }
}