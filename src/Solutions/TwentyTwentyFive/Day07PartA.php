<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day07PartA implements Solution {

    private const START = 'S';
    private const SPLITTER = '^';

    public function solve(Input $input, Output $output): int|string
    {
        $state = [];
        $totalSplits = 0;
        $lines = $input->readLine();

        // Read first and set previous.
        $start = strpos($lines->current(), self::START);
        $state[$start] = true;
        foreach ($lines as $row => $line) {
            // We can ignore every odd row, and the first row.
            if ($row === 0 || !isEven($row)) {
                continue;
            }
            $splits = 0;
            $debug = str_repeat('', 15);
            foreach (str_split($line) as $position => $char) {
                if ($char === self::SPLITTER && isset($state[$position])) {
                    $splits++;
                    $debug[$position] = '^';
                    unset($state[$position]);
                    if (!isset($state[$position-1])) {
                        $state[$position-1] = true;
                    }
                    if (!isset($state[$position+1])) {
                        $state[$position+1] = true;
                    }
                }
            }

            foreach ($state as $k => $v) {
                $debug[$k] = '|';
            }
            $output->writeLine($debug . ' (' . $splits . ')');
            $totalSplits += $splits;
        }
        return $totalSplits;
    }
}
