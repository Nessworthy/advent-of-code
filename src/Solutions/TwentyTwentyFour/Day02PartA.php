<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day02PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $safeReports = 0;
        foreach ($input->readLine() as $reportNumber => $line) {
            $report = array_map('toInt', explode(' ', $line));
            $ascending = true;
            $descending = true;
            $lastVal = $report[0];

            for ($i = 1, $iMax = count($report); $i < $iMax; $i++) {
                $diff = abs($lastVal - $report[$i]);
                if ($diff < 1 || $diff > 3) {
                    $output->writeLine("$reportNumber: too far between $lastVal and $report[$i]");
                    continue 2;
                }
                $descending = $descending && ($report[$i] < $lastVal);
                $ascending = $ascending && ($report[$i] > $lastVal);

                if (!$ascending && !$descending) {
                    $output->writeLine("$reportNumber: no longer ascending or descending at $lastVal $report[$i]");
                    continue 2;
                }
                $lastVal = $report[$i];
            }
            $safeReports++;
        }
        return $safeReports;
    }
}
