<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day07PartB implements Solution {
    private const START = 'S';
    private const SPLITTER = '^';

    public function solve(Input $input, Output $output): int|string
    {
        $state = [];
        $lines = $input->readLine();

        // Read first and set previous.
        $start = strpos($lines->current(), self::START);
        $state[$start] = 1;
        foreach ($lines as $row => $line) {
            // We can ignore every odd row, and the first row.
            if ($row === 0 || !isEven($row)) {
                continue;
            }
            $debug = str_repeat('', 15);
            // So same as part 1 except we use the value to track how many paths have reached that point.
            foreach (str_split($line) as $position => $char) {
                if ($char === self::SPLITTER && isset($state[$position])) {
                    $amount = $state[$position];
                    $debug[$position] = '^';
                    unset($state[$position]);
                    $state[$position-1] = $amount + ($state[$position-1] ?? 0);
                    $state[$position+1] = $amount + ($state[$position+1] ?? 0);
                }
            }

            foreach ($state as $k => $v) {
                $debug[$k] = '|';
            }
            $output->writeLine($debug);
        }
        return array_sum($state);
    }
}
