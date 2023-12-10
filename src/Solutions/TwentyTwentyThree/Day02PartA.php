<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

const LIMIT_RED = 12;
const LIMIT_GREEN = 13;
const LIMIT_BLUE = 14;

const LIMITS = [
    'red' => LIMIT_RED,
    'green' => LIMIT_GREEN,
    'blue' => LIMIT_BLUE
];

class Day02PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $line) {
            [$gameStr, $cubesStr] = explode(': ', $line);
            $game = toInt(str_replace('Game ', '', $gameStr));

            foreach (explode('; ', $cubesStr) as $setIndex => $set) {
                foreach (explode(', ', $set) as $cubes) {
                    [$cubeCount, $cubeColor]  = explode(' ', $cubes);
                    if (LIMITS[$cubeColor] < toInt($cubeCount)) {
                        $output->writeLine('Game ' . $game . ' not possible (at set ' . $setIndex + 1 . ')');
                        continue 3;
                    }
                }
            }
            $output->writeLine('Game ' . $game . ' possible.');
            $total += $game;
        }

        return $total;
    }

}

