<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day02PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $line) {
            [$gameStr, $cubesStr] = explode(': ', $line);
            $game = toInt(str_replace('Game ', '', $gameStr));
            $min = ['red' => 0, 'green' => 0, 'blue' => 0];

            foreach (explode('; ', $cubesStr) as $setIndex => $set) {

                foreach (explode(', ', $set) as $cubes) {
                    [$cubeCount, $cubeColor]  = explode(' ', $cubes);
                    $min[$cubeColor] = max(toInt($cubeCount), $min[$cubeColor]);
                }
            }
            $power = $min['red'] * $min['green'] * $min['blue'];
            $output->writeLine('Game ' . $game . ': ' . $power);
            $total += $power;
        }

        return $total;
    }

}

