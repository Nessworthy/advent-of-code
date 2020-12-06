<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\LineParser;

use stdClass;

class PasswordPolicy
{
    private const REGEX = '#^(?<min>\d+)\-(?<max>\d+) (?<char>[a-z]): (?<string>.+)$#';

    /**
     * @param string $str
     * @return stdClass
     */
    public function parse(string $str): stdClass
    {
        $matches = [];
        preg_match(self::REGEX, $str, $matches);
        return (object) [
            'min' => (int) $matches['min'],
            'max' => (int) $matches['max'],
            'char' => $matches['char'],
            'string' => $matches['string']
        ];
    }
}
