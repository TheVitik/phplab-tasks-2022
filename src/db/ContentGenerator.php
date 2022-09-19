<?php

namespace src\db;

use PDO;

class ContentGenerator
{
    private const LETTER_PATTERN = "/[a-zA-Z]/";

    private const SORT_COLUMNS = ['name', 'code', 'state', 'city'];

    public function __construct(private PDO $pdo, private Paginator $paginator)
    {
    }

    /**
     * Validate GET parameters and return array with
     * valid types of filtering, sorting or paginating
     */
    private function getFilters(array $data): array
    {
        $filters = [];

        if (
            isset($data['filter_by_first_letter'])
            && preg_match(self::LETTER_PATTERN, $data['filter_by_first_letter'])
            && strlen($data['filter_by_first_letter']) == 1
        ) {
            $filters['filter_by_first_letter'] = $data['filter_by_first_letter'];
        }

        if (
            isset($data['filter_by_state'])
            && in_array($data['filter_by_state'], $this->getStates())
        ) {
            $filters['filter_by_state'] = $data['filter_by_state'];
        }

        if (
            isset($data['sort'])
            && in_array($data['sort'], self::SORT_COLUMNS)
        ) {
            $filters['sort'] = $data['sort'];
        }

        if (
            isset($data['page'])
            && is_int((int)$data['page'])
            && $data['page'] >= 1
        ) {
            $filters['page'] = $data['page'];
        }

        return $filters;
    }

    /**
     * Validate GET parameters and return array with
     * valid types of filtering, sorting or paginating
     */
    public function getAirports(array $data): array
    {
        $filters = $this->getFilters($data);

        $sql = 'SELECT airports.name, airports.code, cities.name as city_name, 
                states.state as state_name, airports.address, airports.timezone 
                FROM airports
                INNER JOIN cities ON airports.city_id=cities.id
                INNER JOIN states ON airports.state_id=states.id ';

        if (
            isset($filters['filter_by_state'])
            && isset($filters['filter_by_first_letter'])
        ) {
            $sql .= " WHERE states.state='" . $filters['filter_by_state'] . "' 
                      AND airports.name LIKE '" . $filters['filter_by_first_letter'] . "%' ";
        } elseif (isset($filters['filter_by_state'])) {
            $sql .= " WHERE states.state='" . $filters['filter_by_state'] . "' ";
        } elseif (isset($filters['filter_by_first_letter'])) {
            $sql .= " WHERE airports.name LIKE '" . $filters['filter_by_first_letter'] . "%' ";
        }

        if (isset($filters['sort'])) {
            if ($filters['sort'] == 'city') {
                $sql .= ' ORDER BY cities.name ';
            } else {
                $sql .= ' ORDER BY ' . $filters['sort'] . ' ';
            }
        }

        return $this->paginator->getAirports($sql, $filters['page'] ?? 1);
    }

    private function getStates(): array
    {
        $states = [];

        $result = $this->pdo->query('SELECT state FROM states');
        if ($result) {
            $states = $result->fetchAll(PDO::FETCH_COLUMN);
        }

        return $states;
    }

    public function getUniqueFirstLetters(): array
    {
        $letters = [];

        $result = $this->pdo->query('SELECT DISTINCT LEFT(name, 1) as letter FROM airports ORDER BY letter');
        if ($result) {
            $letters = $result->fetchAll(PDO::FETCH_COLUMN);
        }

        return $letters;
    }
}
