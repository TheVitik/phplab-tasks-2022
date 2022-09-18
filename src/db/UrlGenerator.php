<?php

namespace src\db;

class UrlGenerator
{

    public function generate(string $type, string $key, string $value): string
    {
        $query = '';
        $parameters = [];
        if (empty($_GET)) {
            $query .= "?$key=$value";
        } else {
            $parameters = array_merge($parameters, $_GET);
            $parameters[$key] = $value;

            if (isset($parameters['page'])) {
                if ($type === 'filter') {
                    unset($parameters['page']);
                }
            }

            $order = ['page', 'filter_by_state', 'filter_by_first_letter', 'sort'];
            uksort($parameters, function ($key1, $key2) use ($order) {
                return ((array_search($key1, $order) > array_search($key2, $order)) ? 1 : -1);
            });

            $query .= '?' . http_build_query($parameters);
        }

        return $query;
    }
}
