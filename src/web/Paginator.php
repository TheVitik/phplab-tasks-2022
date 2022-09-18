<?php

namespace src\web;

class Paginator
{
    const AIRPORTS_PER_PAGE = 5;

    public int $page = 1;
    private array $data = [];

    public function pages(): int
    {
        $fullPages = intdiv(count($this->data), self::AIRPORTS_PER_PAGE);

        return (count($this->data) % self::AIRPORTS_PER_PAGE > 0) ? $fullPages + 1 : $fullPages;
    }

    public function results(array $data, int $page): array
    {
        $this->page = $page;
        $this->data = $data;

        if ($page == 1) {
            return array_slice($data, 0, self::AIRPORTS_PER_PAGE);
        }

        return array_slice($data, ($page - 1) * self::AIRPORTS_PER_PAGE, self::AIRPORTS_PER_PAGE);
    }
}
