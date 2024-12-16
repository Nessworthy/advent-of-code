<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Grid\GridDirectionValue;
use Nessworthy\AoC\Solutions\Solution;

class Day04PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $grid = new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );

        $matches = 0;
        $search = ['X', 'M', 'A', 'S'];
        $maxX = $grid->getWidth() - 1;
        $maxY = $grid->getHeight() - 1;
        foreach ($grid->traverseFromTopLeft() as $point => $value) {
            if ($value === 'X') {
                foreach (Point2DHelper::getNeighbouringPoints($point, 0, $maxX, 0, $maxY) as $direction => $neighbouringPoint) {
                    $slice = $grid->getSlice($point, $direction, 4);
                    if ($slice === $search) {
                        $str = implode('', $slice);
                        $directionVal = GridDirectionValue::getValue($direction);
                        $output->writeLine("$str Found {$point->x()},{$point->y()}, $directionVal");
                        $matches++;
                    }
                }
            }
        }
        return $matches;
    }
}
