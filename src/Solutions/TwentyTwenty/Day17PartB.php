<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\Grid\ConwayCube4D;

class Day17PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $grid = new ConwayCube4D();

        foreach ($input->readLine() as $y => $line) {
            foreach (str_split($line) as $x => $char) {
                if ($char === '#') {
                    $grid->setActive((int) $x, (int) $y, 0, 0);
                }
            }
        }

        $currentCycle = 0;

        while ($currentCycle < 6) {
            ++$currentCycle;
            $output->writeLine('Cycle: ' . $currentCycle);
            $newGrid = clone $grid;

            foreach ($grid->getActivePoints() as $activePoint) {
                $output->writeLine('Active point: ' . implode(',', $activePoint));
                if (!$grid->hasTwoOrThreeActiveNeighbours(...$activePoint)) {
                    $output->writeLine('Setting inactive: ' . implode(',', $activePoint));
                    $newGrid->setInactive(...$activePoint);
                }
            }

            foreach ($grid->getInactivePoints() as $inactivePoint) {
                $output->writeLine('Inactive point: ' . implode(',', $inactivePoint));
                if ($grid->hasThreeActiveNeighbours(...$inactivePoint)) {
                    $output->writeLine('Setting active: ' . implode(',', $inactivePoint));
                    $newGrid->setActive(...$inactivePoint);
                }
            }
            $grid = $newGrid;
        }

        return $grid->getNumberOfActivePoints();
    }
}
