<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day02PartB implements Solution {

    private function isValidReport(array $numbers, bool $safetyUsed, string $direction, int|bool $lastVal, Output $output): bool {
        $output->writeLine('Evaluating ' . implode(' ', $numbers) . ' (' . $direction . ')');
        if (count($numbers) < 2) {
            $output->writeLine('Looks like it\'s valid!');
            return true;
        }

        [$first, $second] = $numbers;

        $correctSet = array_slice($numbers, 1);

        $safetySet1 = array_merge($lastVal ? [$lastVal, $second] : [$second], array_slice($numbers, 2));
        $safetySet2 = array_merge($lastVal ? [$lastVal, $first] : [$first], array_slice($numbers, 2));

        $incr = abs($first - $second);
        if ($incr < 1 || $incr > 3) {
            if ($safetyUsed) {
                $output->writeLine('Bzzt: Out of increment range.');
                return false;
            }
            $output->writeLine('Safety used! Not in increment range');
            return $this->isValidReport($safetySet1, true, $direction, false, $output)
                || $this->isValidReport($safetySet2, true, $direction, false, $output);
        }

        if ($direction === 'asc') {
            if ($first < $second) {
                return $this->isValidReport($correctSet, $safetyUsed, $direction, $first, $output);
            }
            if ($safetyUsed) {
                $output->writeLine('Bzzt: Not ascending');
                return false;
            }
            $output->writeLine('Safety used! Not ascending');
            return $this->isValidReport($safetySet1, true, $direction, false, $output)
                || $this->isValidReport($safetySet2, true, $direction, false, $output);
        }

        if ($direction === 'desc') {
            if ($first > $second) {
                return $this->isValidReport($correctSet, $safetyUsed, $direction, $first, $output);
            }
            if ($safetyUsed) {
                $output->writeLine('Bzzt: Not descending.');
                return false;
            }
            $output->writeLine('Safety used! Not descending');
            return $this->isValidReport($safetySet1, true, $direction, false, $output)
                || $this->isValidReport($safetySet2, true, $direction, false, $output);
        }
    }

    public function solve(Input $input, Output $output): int|string
    {
        $safeReports = 0;
        foreach ($input->readLine() as $reportNumber => $line) {
            $report = array_map('toInt', explode(' ', $line));

            if ($this->isValidReport($report, false, 'asc', false, $output)
                || $this->isValidReport($report, false, 'desc', false, $output)) {
                $safeReports++;
            }

        }
        return $safeReports;
    }
}
