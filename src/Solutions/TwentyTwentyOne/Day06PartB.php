<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day06PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $days = 256;
        $day = 0;

        $newFish = [0,0,0,0,0,0,0,0,0];
        $fish    = [0,0,0,0,0,0,0];

        foreach (array_map('toInt', explode(',', $input->readLine()->current())) as $startingFish) {
            ++$fish[$startingFish + 1];
        }

        while ($day <= $days) {
            $newFishIndex = $day % 9;
            $fishIndex = $day % 7;

            $fishToAdd = 0;

            if ($newFish[$newFishIndex] > 0) {
                $fishToAdd = $newFish[$newFishIndex];
            }

            if ($fish[$fishIndex] > 0) {
                $newFish[$newFishIndex] += $fish[$fishIndex];
            }

            $fish[$fishIndex] += $fishToAdd;

            ++$day;
        }

        return array_sum($newFish) + array_sum($fish);
    }
}
