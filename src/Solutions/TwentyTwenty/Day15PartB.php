<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day15PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        # yolo
        ini_set('memory_limit', '10G');
        $numbers = [];
        $turn = 0;
        $last = 0;

        foreach (explode(',', $input->readLine()->current()) as $line) {
            ++$turn;
            $numbers[(int) $line] = [$turn];
            $last = (int) $line;
        }

        while ($turn < 30000000) {
            $turn += 1;
            if (count($numbers[$last]) === 1) {
                $number = 0;
            } else {
                $number = $numbers[$last][array_key_last($numbers[$last])] - array_shift($numbers[$last]);
            }

            $last = $number;
            if (!isset($numbers[$number])) {
                $numbers[$number] = [];
            }
            $numbers[$number][] = $turn;
            $output->writeLine(sprintf('%d: %d', $turn, $last));
        }

        return $last;
    }
}
