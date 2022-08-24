<?php
/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Dont forget to create variables for TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */

namespace src\oop\app\src;

use Exception;
use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

class Scrapper
{
    public function __construct(private TransportInterface $transporter, private ParserInterface $parser)
    {
    }

    /**
     * @throws Exception
     */
    public function getMovie(string $url): Movie
    {
        $content = $this->transporter->getContent($url);

        return $this->parser->parseContent($content);
    }
}
