<?php

namespace src\oop\app\src\Parsers;

use OutOfBoundsException;
use src\oop\app\src\Models\Movie;
use src\oop\app\src\Models\MovieInterface;
use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{

    public function __construct(private Crawler $crawler, private MovieInterface $movie)
    {
    }

    public function parseContent(string $siteContent): Movie
    {
        $this->crawler->addContent($siteContent);

        // Movie title
        $title = $this->crawler->filter('#fheader > h1')->text();
        if (empty($title)) {
            throw new OutOfBoundsException('Parse error: title not found', 500);
        }

        $this->movie->setTitle($title);

        // Movie description
        $description = $this->crawler->filter('#fdesc')->html();
        $description = preg_replace("/<h2>(.*)<\/h2>/", '', $description);
        if (empty($description)) {
            throw new OutOfBoundsException('Parse error: description not found', 500);
        }

        $this->movie->setDescription($description);

        // Movie poster
        $poster = $this->crawler->filter('.fposter a')->attr('href');
        if (empty($poster)) {
            throw new OutOfBoundsException('Parse error: poster not found', 500);
        }

        $this->movie->setPoster($poster);

        return $this->movie;
    }
}
