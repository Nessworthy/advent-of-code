<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day09PartB implements Solution
{
    private array $activeBasins = [];
    private array $activeBasinIndexesTouched = [];
    private array $topThreeBasinSizes = [];

    private const BASIN_SPLIT_NUMBER = 9;

    public function solve(Input $input, Output $output): int|string
    {
        /**
         * Read through the input line by line and collect groups of "basins" on that line.
         * For each basin found, merge or create a new basin (if there are no basins to join on to).
         * After each line, for every basin that wasn't touched, consider closed.
         * Remove them from the tracked basins, calculate their score and compare it to the top scores collected.
         */
        foreach ($input->readLine() as $y => $line) {

            $currentBasinPoints = [];

            foreach  (array_map('toInt', str_split($line)) as $x => $number) {

                if ($number === self::BASIN_SPLIT_NUMBER) {
                    if ($currentBasinPoints) {
                        $this->mergeOrCreateBasin($currentBasinPoints);
                        $currentBasinPoints = [];
                    }
                    continue;
                }

                $currentBasinPoints[] = "$x,$y";

            }

            if ($currentBasinPoints) {
                $this->mergeOrCreateBasin($currentBasinPoints);
            }

            $this->compressBasins();
        }

        // Final compress to evaluate all basins on the final row.
        $this->compressBasins();

        return array_reduce(
            $this->topThreeBasinSizes,
            static function($score, $basinSize) {
                return $basinSize * $score;
            },
            1
        );
    }

    /**
     * Add a new basin, or merge into an existing basin(s) if possible.
     * Should merge multiple touching basins together.
     * @param array $basinPoints
     */
    private function mergeOrCreateBasin(array $basinPoints): void {
        // Establish the possible points this could connect to.
        $row = (int) explode(',', $basinPoints[0])[1];
        $desiredRow = $row - 1;

        if ($desiredRow < 0) {
            // Just create a new basin - we're at the top of the map.
            $this->activeBasins[] = $basinPoints;
            $this->activeBasinIndexesTouched[array_key_last($this->activeBasins)] = true;
            return;
        }

        $joinablePoints = [];

        foreach ($basinPoints as $point) {
            [$x, $y] = explode(',', $point, 2);
            $y = ((int) $y) - 1;
            $joinablePoints[] = "$x,$y";
        }

        $basinsToMerge = [];
        $basinPointsToMerge = [];

        foreach ($this->activeBasins as $activeBasinIndex => $activeBasin) {
            if (count(array_intersect($joinablePoints, $activeBasin))) {
                $basinsToMerge[] = $activeBasinIndex;
                $basinPointsToMerge[] = $activeBasin;
            }
        }

        if ($basinsToMerge) {
            $basinPoints = array_unique(array_merge($basinPoints, ...$basinPointsToMerge));
        }

        foreach ($basinsToMerge as $index) {
            unset($this->activeBasins[$index]);
            if (isset($this->activeBasinIndexesTouched[$index])) {
                unset($this->activeBasinIndexesTouched[$index]);
            }
        }

        $this->activeBasins[] = $basinPoints;
        $this->activeBasinIndexesTouched[array_key_last($this->activeBasins)] = true;
    }

    /**
     * We can confidently say all basins not touched over a given row have been closed off,
     * and can be evaluated for size and purged from the active basin list.
     * This method does just that.
     */
    private function compressBasins(): void {
        $activeBasinsTouched = $this->activeBasinIndexesTouched;
        $this->activeBasinIndexesTouched = [];

        $lowestScore = $this->topThreeBasinSizes ? min($this->topThreeBasinSizes) : 0;

        foreach (array_diff(array_keys($this->activeBasins), array_keys($activeBasinsTouched)) as $basinIndexNotTouched) {
            $size = count($this->activeBasins[$basinIndexNotTouched]);
            if ($size > $lowestScore) {
                if (count($this->topThreeBasinSizes) === 3) {
                    array_pop($this->topThreeBasinSizes);
                }
                $this->topThreeBasinSizes[] = $size;
                rsort($this->topThreeBasinSizes);
                $lowestScore = min($this->topThreeBasinSizes);
            }
            unset($this->activeBasins[$basinIndexNotTouched]);
        }
    }
}
