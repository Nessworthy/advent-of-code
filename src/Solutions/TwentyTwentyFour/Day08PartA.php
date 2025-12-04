<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\InputAdapter;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\Antennae\AntennaeCollector;
use Nessworthy\AoC\TwentyTwentyFour\Vector\Line2D;

class Day08PartA implements Solution {
    private InputAdapter $inputAdapter;
    private AntennaeCollector $antennaeCollector;

    public function __construct(InputAdapter $inputAdapter, AntennaeCollector $antennaeCollector)
    {
        $this->inputAdapter = $inputAdapter;
        $this->antennaeCollector = $antennaeCollector;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = $this->inputAdapter->toGrid($input);
        $antennae = $this->antennaeCollector->collectAntennaePoints($grid);

        $antiNodes = [];

        foreach ($antennae as $symbol => $points) {
            $output->writeLine('Evaluating for ' . $symbol);
            foreach ($points as $index => $point) {
                foreach (array_slice($points, $index + 1) as $secondPoint) {
                    $line = new Line2D($point, $secondPoint);
                    $ahead = $line->next();
                    $behind = $line->prev();

                    if ($grid->isPointInGrid($ahead)) {
                        $antiNodes[$ahead->__toString()] = true;
                    }
                    if ($grid->isPointInGrid($behind)) {
                        $antiNodes[$behind->__toString()] = true;
                    }
                }
            }
        }

        return count($antiNodes);
    }
}
