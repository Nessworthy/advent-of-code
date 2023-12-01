<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';

const TRANSLATE = [
    'one' => '1',
    'two' => '2',
    'three' => '3',
    'four' => '4',
    'five' => '5',
    'six' => '6',
    'seven' => '7',
    'eight' => '8',
    'nine' => '9'
];

class Day01PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $values = 0;
        foreach ($input->readLine() as $line) {
            $translated = strtr($line, TRANSLATE);
            $numbers = array_map('toInt', str_split(trim($translated, ALPHABET)));
            $result = toInt($numbers[0] . end($numbers));
            $output->writeLine($line . ' : ' . '(' . implode('', $numbers) . ') ' . $result);

            $values += $result;
        }
        return $values;
    }
}
