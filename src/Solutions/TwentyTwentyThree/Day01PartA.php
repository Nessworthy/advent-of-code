<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';

class Day01PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $values = 0;
        foreach ($input->readLine() as $line) {
            /*$matches = preg_match('#^(?:[a-z]+)?(\d)(?:[a-z0-9]+)?(\d)(?:[a-z]+)?$#', $line);
            if ($matches === false) {
                return -1;
            }*/
            $numbers = array_map('toInt', str_split(trim($line, ALPHABET)));
            $values += toInt($numbers[0] . end($numbers));

        }
        return $values;
    }

}

