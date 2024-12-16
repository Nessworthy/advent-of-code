<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day03PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $line) {
            $matches = [];
            preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $line, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $total += toInt($match[1]) * toInt($match[2]);
            }
        }
        return $total;
    }
}
