<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * The $input variable contains an array of digits
     * Return an array which will contain the same digits but repetitive by its value
     * without changing the order.
     * Example: [1,3,2] => [1,3,3,3,2,2]
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param array $input
     * @return array
     */
    public function repeatArrayValues(array $input): array
    {
        $array = [];
        foreach($input as $value){
            $tempArray = array_fill(0,$value,$value);
            $array = array_merge($array,$tempArray);
        }
        return $array;
    }

    /**
     * The $input variable contains an array of digits
     * Return the lowest unique value or 0 if there is no unique values or array is empty.
     * Example: [1, 2, 3, 2, 1, 5, 6] => 3
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param array $input
     * @return int
     */
    public function getUniqueValue(array $input): int
    {
        if(count($input)==0){
            return 0;
        }
        $array = [];
        foreach (array_count_values($input) as $key=>$value){
            if($value===1){
                $array[] = $key;
            }
        }
        if(count($array)==0){
            return 0;
        }
        return min($array);
    }


    /**
     * The $input variable contains an array of arrays
     * Each sub array has keys: name (contains strings), tags (contains array of strings)
     * Return the list of names grouped by tags
     * !!! The 'names' in returned array must be sorted ascending.
     *
     * Example:
     * [
     *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
     *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
     *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
     * ]
     *
     * Should be transformed into:
     * [
     *  'fruit' => ['apple', 'orange'],
     *  'green' => ['apple'],
     *  'vegetable' => ['potato'],
     *  'yellow' => ['orange', 'potato'],
     * ]
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param array $input
     * @return array
     */
    public function groupByTag(array $input): array
    {
        $tags = [];
        foreach($input as $arr){
            $tags = array_merge($tags,$arr['tags']);
        }
        $tags = array_unique($tags);
        $array = [];
        foreach($tags as $tag){
            $array[$tag] = [];
            foreach($input as $arr){
                if(in_array($tag,$arr['tags'])){
                    $array[$tag][] = $arr['name'];
                }
            }
            sort($array[$tag]);

        }
        ksort($array);
        return $array;
    }
}