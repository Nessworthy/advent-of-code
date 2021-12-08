<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day07PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $crabs = array_map('toInt', explode(',', $input->readLine()->current()));

        $position = 0;
        $lastFuelCost = null;

        $numberOfCrabs = count($crabs);

        while ($position < $numberOfCrabs) {
            ++$position;
            $cost = $this->calculateFuel($crabs, $position);
            $output->writeLine('Position: ' . $position . ', cost: ' . $cost);
            if ($lastFuelCost !== null && $cost > $lastFuelCost) {
                break;
            }
            $lastFuelCost = $cost;
        }

        return $lastFuelCost;
    }

    private function calculateFuel(array $crabs, int $position): int {
        return array_reduce(
            $crabs,
            static function ($fuelSpent, $crab) use ($position) {
                $diff = max($crab, $position) - min($crab, $position);
                $triangleNumber = ($diff * ($diff + 1)) / 2;
                return $fuelSpent + $triangleNumber;
            },
            0
        );
    }

}
