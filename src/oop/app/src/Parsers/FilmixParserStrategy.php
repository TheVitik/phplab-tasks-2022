<?php

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;

class FilmixParserStrategy implements ParserInterface
{

    /**
     * @return Movie
     */
    public function parseContent(string $siteContent): Movie
    {
        $siteContent = mb_convert_encoding($siteContent, 'utf-8', 'windows-1251');

        $movie = new Movie;

        // Movie title
        $pattern = "/<h1 class=\"name\" itemprop=\"name\">(.*?)<\/h1>/";
        if (preg_match($pattern, $siteContent, $matches)) {
            $movie->setTitle($matches[1]);
        }

        // Movie description
        $pattern = "/<div class=\"full-story\">(.*?)<\/div>/";
        if (preg_match($pattern, $siteContent, $matches)) {
            $movie->setDescription($matches[1]);
        }

        // Movie poster
        $pattern = "/<img src=\"(.*)\" class=\"poster poster-tooltip\"/";
        if (preg_match($pattern, $siteContent, $matches)) {
            $movie->setPoster($matches[1]);
        }

        return $movie;
    }
}