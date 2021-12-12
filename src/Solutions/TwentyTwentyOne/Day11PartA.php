<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\Visualizer\JellyfishFlashers;

class Day11PartA implements Solution
{
    private const MAX_TICKS = 100;
    private JellyfishFlashers $jellyfishFlashers;

    public function __construct(JellyfishFlashers $jellyfishFlashers)
    {
        $this->jellyfishFlashers = $jellyfishFlashers;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $totalFlashes = 0;
        $grid = [];

        foreach ($input->readLine() as $y => $line) {
            $grid[$y] = array_map('toInt', str_split($line));
        }

        for ($tick = 1; $tick <= self::MAX_TICKS; $tick++) {

            $grid = $this->increaseOctopusLevelByOne($grid);

            $flashed = [];
            $flashedThisRun = true;

            while ($flashedThisRun) {
                $flashedThisRun = false;

                foreach ($grid as $y => $row) {
                    foreach ($row as $x => $level) {
                        if ($level > 9 && !isset($flashed["$x,$y"])) {
                            ++$totalFlashes;
                            $flashedThisRun = true;
                            $flashed["$x,$y"] = true;
                            $grid = $this->flashAt($grid, $x, $y);
                        }
                    }
                }
            }

            $this->jellyfishFlashers->display($grid);

            $grid = $this->resetFlashed($grid);
        }

        return $totalFlashes;
    }



    private function increaseOctopusLevelByOne(array $grid): array
    {
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $octopus) {
                ++$grid[$y][$x];
            }
        }

        return $grid;
    }

    private function flashAt(array $grid, int $x, int $y): array
    {
        if (isset($grid[$y][$x-1])) {
            ++$grid[$y][$x - 1];
        }
        if (isset($grid[$y][$x+1])) {
            ++$grid[$y][$x + 1];
        }
        if (isset($grid[$y-1][$x])) {
            ++$grid[$y - 1][$x];
        }
        if (isset($grid[$y+1][$x])) {
            ++$grid[$y + 1][$x];
        }
        if (isset($grid[$y+1][$x+1])) {
            ++$grid[$y + 1][$x + 1];
        }
        if (isset($grid[$y-1][$x-1])) {
            ++$grid[$y-1][$x-1];
        }
        if (isset($grid[$y+1][$x-1])) {
            ++$grid[$y + 1][$x - 1];
        }
        if (isset($grid[$y - 1][$x + 1])) {
            ++$grid[$y - 1][$x + 1];
        }
        return $grid;
    }

    private function resetFlashed(array $grid): array
    {
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $octopus) {
                if ($octopus > 9) {
                    $grid[$y][$x] = 0;
                }
            }
        }

        return $grid;
    }
}

