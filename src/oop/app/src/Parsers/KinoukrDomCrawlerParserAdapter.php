<?php

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;
use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    /**
     * @return Movie
     */
    public function parseContent(string $siteContent): Movie
    {
        $crawler = new Crawler();
        $crawler->addContent($siteContent);

        $movie = new Movie;

        // Movie title
        $title = $crawler->filter('#fheader > h1')->text();
        $movie->setTitle($title);

        // Movie description
        $description = $crawler->filter('#fdesc')->html();
        $description = preg_replace("/<h2>(.*)<\/h2>/", '', $description);
        $movie->setDescription($description);

        // Movie poster
        $poster = $crawler->filter('.fposter a')->attr('href');
        $movie->setPoster($poster);

        return $movie;
    }
}
