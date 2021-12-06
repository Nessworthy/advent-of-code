<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne;

class LanternFishCounter
{
    public function countFishAfterDays(array $initialFish, int $days)
    {
        $day = 0;

        $fish = [0,0,0,0,0,0,0,0,0];

        foreach ($initialFish as $startingFish) {
            ++$fish[$startingFish + 1];
        }

        while ($day <= $days) {
            $fish[($day + 7) % 9] += $fish[$day % 9];
            ++$day;
        }

        return array_sum($fish);
    }
}
