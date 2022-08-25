<?php

namespace src\oop\app\src\Parsers;

use OutOfBoundsException;
use src\oop\app\src\Models\Movie;
use src\oop\app\src\Models\MovieInterface;

class FilmixParserStrategy implements ParserInterface
{
    const TITLE_PATTERN = "/<h1 class=\"name\" itemprop=\"name\">(.*?)<\/h1>/";
    const DESCRIPTION_PATTERN = "/<div class=\"full-story\">(.*?)<\/div>/";
    const POSTER_PATTERN = "/<img src=\"(.*)\" class=\"poster poster-tooltip\"/";

    public function __construct(private MovieInterface $movie)
    {
    }

    public function parseContent(string $siteContent): Movie
    {
        $siteContent = mb_convert_encoding($siteContent, 'utf-8', 'windows-1251');

        // Movie title
        if (preg_match(self::TITLE_PATTERN, $siteContent, $matches)) {
            if (empty($matches[1])) {
                throw new OutOfBoundsException('Parse error: title not found', 500);
            }

            $this->movie->setTitle($matches[1]);
        }

        // Movie description
        if (preg_match(self::DESCRIPTION_PATTERN, $siteContent, $matches)) {
            if (empty($matches[1])) {
                throw new OutOfBoundsException('Parse error: description not found', 500);
            }

            $this->movie->setDescription($matches[1]);
        }

        // Movie poster
        if (preg_match(self::POSTER_PATTERN, $siteContent, $matches)) {
            if (empty($matches[1])) {
                throw new OutOfBoundsException('Parse error: poster not found', 500);
            }

            $this->movie->setPoster($matches[1]);
        }

        return $this->movie;
    }
}
