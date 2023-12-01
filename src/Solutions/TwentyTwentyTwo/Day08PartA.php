<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\TreeGrid\TreeGrid;

class Day08PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $grid = new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );

        $treeGrid = new TreeGrid($grid);

        return $treeGrid->getVisibleTrees();
    }
}
