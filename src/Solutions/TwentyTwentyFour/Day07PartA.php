<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day07PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $sum = 0;

        foreach ($input->readLine() as $line) {
            $parts = explode(' ', $line);
            $total = toInt(rtrim($parts[0], ':'));
            $numbers = array_map('toInt', array_slice($parts, 1));
            if ($this->calculate($total, 0, $numbers, $output, [$total . ' ='])) {
                $sum += $total;
            }
        }

        return $sum;
    }

    private function calculate(int $total, int $current, array $numbers, Output $output, array $debug = []): bool {
        if (count($debug) === 1) {
            $temp = array_shift($numbers);
            $debug = array_merge($debug, [$temp]);
            return $this->calculate($total, $temp, $numbers, $output, $debug);
        }

        if (!count($numbers)) {
            if ($total === $current) {
                $output->writeLine(implode(' ', $debug));
                return true;
            }
            return false;
        }
        $num = array_shift($numbers);
        $added = $current + $num;
        $multiplied = $current * $num;
        $addDebug = array_merge($debug, ['+ ' . $num]);
        $multDebug = array_merge($debug, ['* ' . $num]);

        return ($multiplied <= $total && $this->calculate($total, $multiplied, $numbers, $output, $multDebug)) || ($added <= $total && $this->calculate($total, $added, $numbers, $output, $addDebug));
    }
}
