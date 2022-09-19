<?php

namespace src\web;

class ContentGenerator
{
    private const LETTER_PATTERN = "/[a-zA-Z]/";

    private const SORT_COLUMNS = ['name', 'code', 'state', 'city'];

    public function __construct(private array $airports, private Paginator $paginator)
    {
    }

    /**
     * Validate GET parameters and return array with
     * valid types of filtering, sorting or paginating
     */
    private function getFilters(array $data): array
    {
        $filters = [];

        if (isset($data['filter_by_first_letter'])
            && preg_match(self::LETTER_PATTERN, $data['filter_by_first_letter'])
            && strlen($data['filter_by_first_letter']) == 1) {
            $filters['filter_by_first_letter'] = $data['filter_by_first_letter'];
        }

        if (isset($data['filter_by_state'])
            && in_array($data['filter_by_state'], $this->getStates())) {
            $filters['filter_by_state'] = $data['filter_by_state'];
        }

        if (isset($data['sort'])
            && in_array($data['sort'], self::SORT_COLUMNS)) {
            $filters['sort'] = $data['sort'];
        }

        if (isset($data['page'])
            && is_int((int)$data['page'])
            && $data['page'] >= 1) {
            $filters['page'] = $data['page'];
        }

        return $filters;
    }

    /**
     * Apply filters and sorting
     * and return array of airports
     */
    public function getAirports(array $data): array
    {
        $filters = $this->getFilters($data);
        $result = $this->airports;

        if (! empty($filters)) {
            foreach ($result as $key => $airport) {
                if (isset($filters['filter_by_first_letter'])) {
                    if ($filters['filter_by_first_letter'] !== $airport['name'][0]) {
                        unset($result[$key]);
                    }
                }

                if (isset($filters['filter_by_state'])) {
                    if ($filters['filter_by_state'] !== $airport['state']) {
                        unset($result[$key]);
                    }
                }
            }
        }

        if (isset($filters['sort'])) {
            $sort_by_key = $filters['sort'];
            uasort($result, function ($key1, $key2) use ($sort_by_key) {
                return strcasecmp($key1[$sort_by_key], $key2[$sort_by_key]);
            });
        }

        return $this->paginator->getAirports($result, $filters['page'] ?? 1);
    }

    /**
     * Get array of states
     */
    private function getStates(): array
    {
        $result = [];
        foreach ($this->airports as $airport) {
            $result[] = $airport['state'];
        }

        return $result;
    }
}
