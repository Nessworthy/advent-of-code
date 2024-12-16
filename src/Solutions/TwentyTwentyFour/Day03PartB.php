<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day03PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        $lines = '';
        foreach ($input->readLine() as $line) {
            $lines .= $line . "\n";
        }
        $enabled = true;
        $matches = [];
        preg_match_all('/(do(?:n\'t)?\(\)|mul\((\d{1,3}),(\d{1,3})\))/', $lines, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            if ($match[1] === 'do()') {
                $enabled = true;
            } else if ($match[1] === 'don\'t()') {
                $enabled = false;
            } else if ($enabled) {
                $total += toInt($match[2]) * toInt($match[3]);
            }
        }
        return $total;
    }
}
