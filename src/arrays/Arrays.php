<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * @param int[] $input
     * @return int[]
     */
    public function repeatArrayValues(array $input): array
    {
        $result = [];
        foreach ($input as $value) {
            $tempArray = array_fill(0, $value, $value);
            $result = array_merge($result, $tempArray);
        }

        return $result;
    }

    /**
     * @param int[] $input
     */
    public function getUniqueValue(array $input): int
    {
        if (count($input) == 0) {
            return 0;
        }
        $uniqueValues = [];
        foreach (array_count_values($input) as $value => $valueCount) {
            if ($valueCount === 1) {
                $uniqueValues[] = $value;
            }
        }
        if (count($uniqueValues) == 0) {
            return 0;
        }

        return min($uniqueValues);
    }


    /**
     * @param array $input [
     *      'name' => string,
     *      'tags' => [string]
     * ]
     * @return array [
     *      $key => [string]
     * ]
     */
    public function groupByTag(array $input): array
    {
        $tags = [];
        foreach ($input as $arr) {
            $tags = array_merge($tags, $arr['tags']);
        }
        $tags = array_unique($tags);
        $result = [];
        foreach ($tags as $tag) {
            $result[$tag] = [];
            foreach ($input as $arr) {
                if (in_array($tag, $arr['tags'])) {
                    $result[$tag][] = $arr['name'];
                }
            }
            sort($result[$tag]);

        }
        ksort($result);
        return $result;
    }
}
