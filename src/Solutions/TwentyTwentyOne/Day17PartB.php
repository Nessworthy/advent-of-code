<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use RuntimeException;

class Day17PartB implements Solution
{
    private const INPUT_PATTERN = '#^target area: x=(?<x1>-?\d+)..(?<x2>-?\d+), y=(?<y1>-?\d+)..(?<y2>-?\d+)$#';

    public function solve(Input $input, Output $output): int|string
    {
        // #bruteforce
        $matches = [];

        if (!preg_match(self::INPUT_PATTERN, $input->readLine()->current(), $matches)) {
            throw new RuntimeException('Not able to read input. :(');
        }

        $xMin = (int) $matches['x1'];
        $xMax = (int) $matches['x2'];
        $yMin = (int) $matches['y1'];
        $yMax = (int) $matches['y2'];

        $maxForNow = 1000;

        $peakHeight = 0;

        $ticksForVerticalAlignment = [];

        $initialVerticalVelocities = [];
        $initialHorizontalVelocities = [];

        for ($startVelocity = $yMin; $startVelocity <= $maxForNow; ++$startVelocity) {
            foreach ($this->willVelocityReachRange($startVelocity, $yMin, $yMax) as [$result, $ticks, $initialVelocity]) {
                $peakHeight = $peakHeight > $result ? $peakHeight : $result;
                // $output->writeLine($startVelocity . " (" . $result . ")");
                if (!isset($ticksForVerticalAlignment[$ticks])) {
                    $ticksForVerticalAlignment[$ticks] = 0;
                }
                ++$ticksForVerticalAlignment[$ticks];
                $initialVerticalVelocities[] = [$initialVelocity, $ticks];
            }
        }

        $ticksForHorizontalAlignment = [];

        // Taking the highest number of ticks as the maximum, find how many starting horizontal velocities
        // can be in the zone at each tick.

        $maxTicks = max(array_keys($ticksForVerticalAlignment));

        for ($startVelocity = 0; $startVelocity <= $xMax; ++$startVelocity) {
            $tick = 0;
            $position = 0;
            $velocity = $startVelocity;
            while ($tick < $maxTicks && $position <= $xMax && ($velocity > 0 || $position >= $xMin)) {
                ++$tick;
                $position += $velocity;
                $velocity = $velocity > 0 ? $velocity - 1 : $velocity;

                if ($position >= $xMin && $position <= $xMax) {
                    if (!isset($ticksForHorizontalAlignment[$tick])) {
                        $ticksForHorizontalAlignment[$tick] = 0;
                    }
                    ++$ticksForHorizontalAlignment[$tick];

                    $initialHorizontalVelocities[] = [$startVelocity, $tick];
                }
            }
        }

        $velocities = [];

        foreach ($initialVerticalVelocities as [$verticalVelocity, $verticalTick]) {
            foreach ($initialHorizontalVelocities as [$horizontalVelocity, $horizontalTick]) {
                if ($verticalTick === $horizontalTick) {
                    $velocities[$horizontalVelocity . ',' . $verticalVelocity] = true;
                    $output->writeLine($horizontalVelocity . ',' . $verticalVelocity);
                }
            }
        }


        return count($velocities);
    }

    private function willVelocityReachRange(int $velocity, int $min, int $max): Generator
    {
        $initialVelocity = $velocity;
        $position = 0;
        $peakHeight = 0;
        $ticks = 0;
        while ($velocity >= 0 || $position > $min) {
            ++$ticks;
            $position += $velocity;
            --$velocity;
            if ($position > $peakHeight) {
                $peakHeight = $position;
            }

            if ($position >= $min && $position <= $max) {
                yield [$peakHeight, $ticks, $initialVelocity];
            }
        }
    }

}
