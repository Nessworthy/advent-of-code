<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\InputAdapter;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Grid\GridDirectionValue;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\GridTraversal\SecurityGuard;

class Day06PartB implements Solution {
    private InputAdapter $inputAdapter;
    private SecurityGuard $securityGuard;

    public function __construct(InputAdapter $inputAdapter, SecurityGuard $securityGuard)
    {
        $this->inputAdapter = $inputAdapter;
        $this->securityGuard = $securityGuard;
    }

    private function getGuardPath(Grid $grid, Point2D $startPosition): array {
        $visited = [];

        foreach ($this->securityGuard->traverse($grid, $startPosition) as $point => $direction) {
            if (!isset($visited[$point->__toString()])) {
                $visited[$point->__toString()] = [];
            }
            if (isset($visited[$point->__toString()][GridDirectionValue::getValue($direction)])) {
                return [
                    'route' => $visited,
                    'isInfinite' => true,
                ];
            }
            $visited[$point->__toString()][GridDirectionValue::getValue($direction)] = [
                'point' => $point,
                'direction' => $direction,
            ];
        }
        return [
            'route' => $visited,
            'isInfinite' => false,
        ];
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = $this->inputAdapter->toGrid($input);

        $startingLocation = $grid->findFirst('^');
        if (!$startingLocation) {
            throw new \RuntimeException('Could not find guard.');
        }
        $output->writeLine('Security guard found at ' . $startingLocation);


        $result = $this->getGuardPath($grid, $startingLocation);
        if ($result['isInfinite']) {
            throw new \RuntimeException('Initial path is looped!');
        }
        $guardPath = $result['route'];
        $obstructions = 0;
        $obstaclePointCache = [];

        $totalSteps = count($guardPath);
        $output->writeLine($totalSteps . ' total steps to try.');

        $i = 0;
        foreach ($guardPath as $pathDirections) {
            $i++;
            foreach ($pathDirections as ['point' => $point, 'direction' => $direction]) {
                // Ignore starting point.
                if ($point->is($startingLocation)) {
                    continue;
                }
                // Ignore previously used positions
                if (isset($obstaclePointCache[$point->__toString()])) {
                    continue;
                }
                $output->writeLine('Trying ' . $point . ' (' . $i . ' / ' . $totalSteps . ')');
                $obstaclePointCache[$point->__toString()] = true;
                $obstacledGrid = $grid->setValueAt($point, '#');
                ['isInfinite' => $isInfinite] = $this->getGuardPath($obstacledGrid, $startingLocation);
                if ($isInfinite) {
                    $output->writeLine('Loops when obstacle is placed at ' . $point);
                    $obstructions++;
                }
            }
        }

        return $obstructions;
    }
}
