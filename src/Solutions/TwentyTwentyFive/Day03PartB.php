<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFive\BatteryBank\BatteryBank;

class Day03PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $i => $line) {
            $batteryBank = new BatteryBank($line);
            $joltage = $batteryBank->getLargestJoltage(12);
            $output->writeLine(sprintf('JV %d = %s', $i + 1, $joltage));
            $total += $joltage;
        }

        return $total;
    }
}
