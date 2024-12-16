<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

const SEPARATOR = '   ';

class Day01PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $listA = [];
        $listB = [];

        foreach ($input->readLine() as $line) {
            $numbers = array_map('toInt', explode(SEPARATOR, $line));
            $listA[] = $numbers[0];
            $listB[] = $numbers[1];
        }

        sort($listA);
        sort($listB);

        $total = 0;

        foreach ($listA as $index => $number) {
            $total += difference($number, $listB[$index]);
        }

        return $total;
    }
}
