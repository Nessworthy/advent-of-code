<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\TreeGrid\TreeGrid;

class Day08PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {

        $total = 0;
        foreach ($this->bullshit() as $i => $solution) {
            $total++;
            $output->writeLine($solution);
        }
        return $total;

        $grid = new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );

        $treeGrid = new TreeGrid($grid);

        return $treeGrid->getVisibleTrees();
    }

    private function bullshit(int $length = 5, int $index = 0, string $current = ''): \Generator {
        if ($length === 0) {
            if (!str_contains($current, 'r') || !str_contains($current, 'a')) {
                return;
            }

            if (!(str_contains($current, 'x') || str_contains($current, 'z'))) {
                return;
            }

            yield $current;
            return;
        }

        $letters = str_split('riafgjbmxz');

        if ($index === 1) {
            $current .= 'i';
            yield from $this->bullshit($length - 1, $index + 1, $current);
            return;
        }

        foreach ($letters as $letter) {
            if ($index === 2 && in_array($letter, ['r', 'i'])) {
                continue;
            } elseif ($index === 3 && $letter === 'a') {
                continue;
            } elseif ($index === 4 && $letter === 'r') {
                continue;
            }
            $result = $current;
            $result .= $letter;
            yield from $this->bullshit($length - 1, $index + 1, $result);
        }
    }
}
