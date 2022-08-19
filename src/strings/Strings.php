<?php

namespace strings;

class Strings implements StringsInterface
{
    public function snakeCaseToCamelCase(string $input): string
    {
        if (! str_contains($input, '_')) {
            return $input;
        }

        for ($i = 0; $i < strlen($input); $i++) {
            if ($input[$i] == '_') {
                $input[$i + 1] = strtoupper($input[$i + 1]);
            }
        }

        return str_replace('_', '', $input);
    }

    public function mirrorMultibyteString(string $input): string
    {
        $words = mb_str_split($input);
        $reversedWords = array_reverse($words);
        $str = implode('', $reversedWords);
        $reversedWords = explode(' ', $str);
        $words = array_reverse($reversedWords);

        return implode(' ', $words);
    }

    public function getBrandName(string $noun): string
    {
        $noun = strtolower($noun);
        if ($noun[0] === $noun[-1]) {
            return ucfirst(substr($noun, 0, -1) . $noun);
        }

        return 'The ' . ucfirst($noun);
    }
}
