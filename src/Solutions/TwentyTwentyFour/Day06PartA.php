<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\InputAdapter;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\GridDirectionValue;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\GridTraversal\SecurityGuard;

class Day06PartA implements Solution {
    private InputAdapter $inputAdapter;
    private SecurityGuard $securityGuard;

    public function __construct(InputAdapter $inputAdapter, SecurityGuard $securityGuard)
    {
        $this->inputAdapter = $inputAdapter;
        $this->securityGuard = $securityGuard;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = $this->inputAdapter->toGrid($input);

        $startingLocation = $grid->findFirst('^');
        if (!$startingLocation) {
            throw new \RuntimeException('Could not find guard.');
        }
        $output->writeLine('Security guard found at ' . $startingLocation);

        $visited = [];

        foreach ($this->securityGuard->traverse($grid, $startingLocation) as $point => $direction) {
            if (!isset($visited[$point->__toString()])) {
                $visited[$point->__toString()] = [];
            }
            if (isset($visited[$point->__toString()][GridDirectionValue::getValue($direction)])) {
                throw new \RuntimeException('I think we\'ve hit an infinite loop.');
            }
            $visited[$point->__toString()][GridDirectionValue::getValue($direction)] = true;
        }

        return count($visited);
    }
}
