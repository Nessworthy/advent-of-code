<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day15PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $grid = [];
        foreach($input->readLine() as $line) {
            $grid[] = str_split($line);
        }

        $distances = ['0,0' => 0];

        $nodeQueue = [[0,0]];

        $pointToFind = (count($grid) - 1) . ',' . (count($grid[0]) - 1);

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

            $output->writeLine($nodeKey);

            foreach ($this->neighbours($node) as $neighbourNode) {
                $key = $neighbourNode[0] . ',' . $neighbourNode[1];
                if (isset($visited[$key]) || !isset($grid[$neighbourNode[0]][$neighbourNode[1]])) {
                    continue;
                }
                $nodeQueue[$key] = $neighbourNode;
                $distance = $distances[$nodeKey] + (int) $grid[$neighbourNode[0]][$neighbourNode[1]];
                if (!isset($distances[$key]) || $distances[$key] > $distance) {
                    $distances[$key] = $distance;
                }
            }
        }

        return $distances[$pointToFind];
    }

    private function neighbours(array $point): array {
        $nodes = [];
        //$nodes[] = [$point[0] - 1, $point[1]];
        $nodes[] = [$point[0] + 1, $point[1]];
        $nodes[] = [$point[0], $point[1] + 1];
        //$nodes[] = [$point[0], $point[1] - 1];
        return $nodes;
    }
}

