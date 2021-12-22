<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day17PartA implements Solution
{
    private const INPUT_PATTERN = '#^target area: x=(?<x1>-?\d+)..(?<x2>-?\d+), y=(?<y1>-?\d+)..(?<y2>-?\d+)$#';

    public function solve(Input $input, Output $output): int|string
    {
        // #bruteforce
        $matches = [];

        if (!preg_match(self::INPUT_PATTERN, $input->readLine()->current(), $matches)) {
            throw new \RuntimeException('Not able to read input. :(');
        }

        $xMin = (int) $matches['x1'];
        $xMax = (int) $matches['x2'];
        $yMin = (int) $matches['y1'];
        $yMax = (int) $matches['y2'];

        $maxForNow = 1000;

        $peakHeight = 0;

        $ticksForVerticalAlignment = [];

        for ($startVelocity = $yMin; $startVelocity <= $maxForNow; ++$startVelocity) {
            [$result, $ticks] = $this->willVelocityReachRange($startVelocity, $yMin, $yMax);
            if ($result !== null) {
                $peakHeight = $peakHeight > $result ? $peakHeight : $result;
                $output->writeLine($startVelocity . " (" . $result . ")");
                if (!isset($ticksForVerticalAlignment[$ticks])) {
                    $ticksForVerticalAlignment[$ticks] = 0;
                }
                ++$ticksForVerticalAlignment[$ticks];
            } else {
                $output->writeLine($startVelocity . " (miss)");
            }
        }

        return $peakHeight;
    }

    private function willVelocityReachRange(int $velocity, int $min, int $max): ?array
    {
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
                return [$peakHeight, $ticks];
            }
        }

        return [null, null];
    }

}
