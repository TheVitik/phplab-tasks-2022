<?php

namespace src\db;

use PDO;

class Paginator
{
    const AIRPORTS_PER_PAGE = 5;

    public int $page = 1;

    public function __construct(private PDO $pdo)
    {

    }

    public function getPagesCount(): int
    {
        $sql = str_replace(
            'airports.name, airports.code, cities.name as city_name, 
                states.state as state_name, airports.address, airports.timezone',
            'COUNT(*)',
            $this->sql
        );
        $result = $this->pdo->query($sql);

        $count = 0;
        if ($result) {
            $count = $result->fetchColumn();
        }

        $fullPages = intdiv($count, self::AIRPORTS_PER_PAGE);

        return ($count % self::AIRPORTS_PER_PAGE > 0) ? $fullPages + 1 : $fullPages;
    }

    /**
     * Paginate result array with airports
     */
    public function getAirports(string $sql, int $page): array
    {
        $this->page = $page;
        $this->sql = $sql;

        if ($page == 1) {
            $sql .= 'LIMIT 0, ' . self::AIRPORTS_PER_PAGE;
        } else {
            $sql .= 'LIMIT ' . ($page - 1) * self::AIRPORTS_PER_PAGE . ', ' . self::AIRPORTS_PER_PAGE;
        }
        $result = $this->pdo->query($sql);

        $airports = [];
        while ($airport = $result->fetch(PDO::FETCH_ASSOC)) {
            $airports[] = $airport;
        }

        return $airports;
    }
}
