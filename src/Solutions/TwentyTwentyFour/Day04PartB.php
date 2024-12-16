<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Grid\GridDirection;
use Nessworthy\AoC\Grid\GridDirectionValue;
use Nessworthy\AoC\Solutions\Solution;

class Day04PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $grid = new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );

        $total = 0;
        $matches = [['M', 'A', 'S'], ['S', 'A', 'M']];

        foreach ($grid->traverseFromTopLeft() as $point => $value) {
            if ($value === 'A') {
                $top = $grid->getSlice(
                    Point2DHelper::bump($point, GridDirection::DIAGONAL_UP_LEFT),
                    GridDirection::DIAGONAL_DOWN_RIGHT,
                    3
                );
                if (!in_array($top, $matches)) {
                    continue;
                }
                $bottom = $grid->getSlice(
                    Point2DHelper::bump($point, GridDirection::DIAGONAL_DOWN_LEFT),
                    GridDirection::DIAGONAL_UP_RIGHT,
                    3
                );
                if (!in_array($bottom, $matches)) {
                    continue;
                }
                $total++;
            }
        }
        return $total;
    }
}
