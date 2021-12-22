<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day15PartB implements Solution
{
    private const MAX_TILES = 5;
    public function solve(Input $input, Output $output): int|string
    {
        $grid = [];
        foreach($input->readLine() as $line) {
            $grid[] = str_split($line);
        }

        $gridSize = count($grid);

        $distances = ['0,0' => 0];

        $nodeQueue = [[0,0]];

        $pointToFind = $gridSize * self::MAX_TILES - 1 . ',' . $gridSize * self::MAX_TILES - 1;

        while (!empty($nodeQueue)) {
            $shortestDistance = null;
            $nextNodeIndex = null;
            $nextNode = null;
            foreach ($nodeQueue as $index => $node) {
                $nodeKey = $node[0] . ',' . $node[1];
                if (
                    $shortestDistance === null
                    || (isset($distances[$nodeKey]) && $distances[$nodeKey] < $shortestDistance)
                ) {
                    $shortestDistance = $distances[$nodeKey];
                    $nextNode = $node;
                    $nextNodeIndex = $index;
                }
            }
            $node = $nextNode;
            unset($nodeQueue[$nextNodeIndex]);
            $nodeKey = $node[0] . ',' . $node[1];
            $visited[$nodeKey] = true;

            $output->writeLine($nodeKey . ' (' . $shortestDistance . ')');

            foreach ($this->neighbours($node) as $neighbourNode) {
                $key = $neighbourNode[0] . ',' . $neighbourNode[1];
                if (isset($visited[$key])
                    || !$this->gridPositionExists($gridSize, $neighbourNode[0], $neighbourNode[1])
                ) {
                    continue;
                }
                $nodeQueue[$key] = $neighbourNode;
                $distance = $distances[$nodeKey] + $this->gridPosition(
                    $grid,
                    $gridSize,
                    $neighbourNode[0],
                    $neighbourNode[1]
                );
                if (!isset($distances[$key]) || $distances[$key] > $distance) {
                    $distances[$key] = $distance;
                }
            }
        }

        return $distances[$pointToFind];
    }

    private function gridPositionExists(int $gridSize, int $x, int $y): bool {
        $max = $gridSize * self::MAX_TILES - 1;
        return $x >= 0 && $y >= 0 && $x <= $max && $y <= $max;
    }

    private function gridPosition(array &$grid, int $gridSize, int $x, int $y): int {

        $mod = (int) (
            ($x === 0 ? 0 : floor($x / $gridSize))
            + ($y === 0 ? 0 : floor($y / $gridSize))
        );
        $base = (int) $grid[$y % $gridSize][$x % $gridSize];

        $total = $base + $mod;

        /**
         * Ensure that 9s wrap around to 1s.
         */
        return $total <= 9 ? $total : (($total - 1) % 9 + 1);
    }

    private function neighbours(array $point): array {
        $nodes = [];
        $nodes[] = [$point[0] + 1, $point[1]];
        $nodes[] = [$point[0], $point[1] + 1];
        $nodes[] = [$point[0] - 1, $point[1]];
        $nodes[] = [$point[0], $point[1] - 1];
        return $nodes;
    }
}

