<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day20PartA implements Solution
{
    private const PIXEL = '#';
    private const EMPTY = '.';

    public function solve(Input $input, Output $output): int|string
    {
        $gen = $input->readLine();
        $imageEnhancementAlgorithm = $gen->current();

        $gen->next();
        $gen->next();

        $grid = [];
        $newGrid = [];

        while ($line = $gen->current()) {
            $grid[] = str_split($line);
            $gen->next();
        }

        $originalLength = count($grid[0]);
        $originalHeight = count($grid);

        $pass = 0;

        while ($pass < 2) {

            ++$pass;

            $minY = 0 - $pass * 3;
            $maxY = $originalHeight + $pass * 3;
            $minX = 0 - $pass * 3;
            $maxX = $originalLength + $pass * 3;

            for ($currentY = $minY; $currentY <= $maxY; ++$currentY) {
                for ($currentX = $minX; $currentX <= $maxX; ++$currentX) {
                    if (!isset($newGrid[$currentY])) {
                        $newGrid[$currentY] = [];
                    }
                    $newGrid[$currentY][$currentX] = $this->enhancePoint(
                        $currentX,
                        $currentY,
                        $grid,
                        $imageEnhancementAlgorithm
                    );
                }
            }

            $grid = $newGrid;
        }

        echo "\n";
        $count = 0;
        ksort($grid);
        foreach ($grid as $y => $line) {
            ksort($line);
            if ($y < 0 - $pass || $y > $originalHeight + $pass) {
                continue;
            }
            $line = array_slice($line, $pass * 3 - $pass, $originalLength + $pass * 2);
            $count += array_reduce(
                $line,
                function ($carry, $val) {
                    return $val === self::PIXEL ? $carry + 1 : $carry;
                }, 0);
            echo implode('', $line) . "\n";
        }

        return $count;
    }

    private function enhancePoint(int $x, int $y, array &$grid, &$imageEnhancementAlgorithm): string
    {
        $index = bindec(implode(
            '',
            array_map(
                function ($point) use ($grid) {
                    return $this->getValue($point[0], $point[1], $grid);
                },
                $this->getEnhancementGroups($x, $y)
            )
        ));

        return $imageEnhancementAlgorithm[$index];
    }

    private function getEnhancementGroups(int $x, int $y): array
    {
        return [
            [$x - 1, $y - 1],
            [$x, $y - 1],
            [$x + 1, $y - 1],
            [$x - 1, $y],
            [$x, $y],
            [$x + 1, $y],
            [$x - 1, $y + 1],
            [$x, $y + 1],
            [$x + 1, $y + 1]
        ];
    }

    private function getValue(int $x, int $y, array &$grid): int
    {
        $char = $grid[$y][$x] ?? self::EMPTY;
        return $char === self::PIXEL ? 1 : 0;
    }
}
