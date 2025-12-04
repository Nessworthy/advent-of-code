<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\InputAdapter;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\Antennae\AntennaeCollector;
use Nessworthy\AoC\TwentyTwentyFour\Vector\Line2D;

class Day08PartB implements Solution {
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

                    foreach ($this->whileInGrid($line, 'next', $grid) as $nextPoint) {
                        $antiNodes[$nextPoint->__toString()] = $nextPoint;
                    }

                    foreach ($this->whileInGrid($line, 'prev', $grid) as $prevPoint) {
                        $antiNodes[$prevPoint->__toString()] = $prevPoint;
                    }
                }
            }
        }

        return count($antiNodes);
    }

    private function whileInGrid(Line2D $line, string $direction, Grid $grid): \Generator {
        for ($i = 0; true; $i++) {
            $point = $line->$direction($i);
            if (!$grid->isPointInGrid($point)) {
                return;
            }
            yield $point;
        }
    }
}
