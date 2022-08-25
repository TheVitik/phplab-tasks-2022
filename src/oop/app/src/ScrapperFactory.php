<?php

namespace src\oop\app\src;

use GuzzleHttp\Client;
use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\KinoukrDomCrawlerParserAdapter;
use src\oop\app\src\Parsers\FilmixParserStrategy;
use src\oop\app\src\Transporters\CurlStrategy;
use src\oop\app\src\Transporters\GuzzleAdapter;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

class ScrapperFactory
{
    /**
     * @throws Exception
     */
    public function create(string $domain): Scrapper
    {
        return match ($domain) {
            'filmix' => new Scrapper(new CurlStrategy(), new FilmixParserStrategy(new Movie())),
            'kinoukr' => new Scrapper(
                new GuzzleAdapter(new Client()),
                new KinoukrDomCrawlerParserAdapter(new Crawler(), new Movie())
            ),
            default => throw new Exception('Resource not found!', 404),
        };
    }
}
