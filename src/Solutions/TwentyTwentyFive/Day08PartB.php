<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point3D;
use Nessworthy\AoC\Solutions\Context;
use Nessworthy\AoC\Solutions\Solution;

class Day08PartB implements Solution {
    private Context $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $connectionLimit = ($this->context->isTestRun() ? 10 : 1000) * 10;

        $points = [];
        $pointCircuits = [];
        $nextCircuitId = 0;
        $neighboursByDistance = [];

        foreach ($input->readLine() as $line) {
            $points[] = new Point3D(...array_map('toInt', explode(',', $line)));
        }

        // Determine closest connections to each point.
        $pointCount = count($points);

        $furthestDistance = null;
        $iterations = 0;

        for ($pointIndex = 0; $pointIndex < $pointCount; $pointIndex++) {
            for ($neighbourPointIndex = $pointIndex + 1; $neighbourPointIndex < $pointCount; $neighbourPointIndex++) {
                $distance = $points[$pointIndex]->getEuclideanDistanceTo($points[$neighbourPointIndex]);

                if ($iterations > $connectionLimit) {
                    // Memory optimization 1: Skip storing info about neighbours we're never going to pair.
                    if ($distance > $furthestDistance) {
                        continue;
                    }
                }
                $furthestDistance = $furthestDistance === null || $distance > $furthestDistance ? $distance : $furthestDistance;

                $neighboursByDistance[] = ["distance" => $distance, "a" => $pointIndex, "b" => $neighbourPointIndex];

                // Memory optimization 2: Every 1000, sort and trim the fat.
                if ($iterations % $connectionLimit === 0 && $iterations !== 0) {
                    $output->writeLine('Trimming the fat on i ' . $iterations);
                    usort($neighboursByDistance, static fn ($a, $b) => $a["distance"] <=> $b["distance"]);
                    $neighboursByDistance = array_slice($neighboursByDistance, 0, $connectionLimit);
                    $furthestDistance = $neighboursByDistance[$connectionLimit - 1]["distance"];
                }

                $iterations++;
            }
        }

        $output->writeLine('Processed ' . count($points) . ' points!');

        usort($neighboursByDistance, static fn ($a, $b) => $a["distance"] <=> $b["distance"]);

        $circuitCache = [];
        for ($connection = 0; $connection < $connectionLimit; $connection++) {
            $details = $neighboursByDistance[$connection];
            $a = $points[$details['a']];
            $b = $points[$details['b']];
            $output->writeLine(sprintf('Connection: (%d units) %s - %s', $details['distance'], $details['a'], $details['b']));
            // Check if either are in any circuit.
            $aGroup = [$details['a']];
            $aKey = $a->__toString();
            $bKey = $b->__toString();

            $aCacheKey = $circuitCache[$aKey] ?? null;
            $bCacheKey = $circuitCache[$bKey] ?? null;

            if ($aCacheKey && $bCacheKey && $aCacheKey === $bCacheKey) {
                $output->writeLine('  Pairing is already in the same circuit, ignoring :)');
                continue;
            }

            if (isset($circuitCache[$aKey])) {
                $circuitKey = $circuitCache[$aKey];
                $output->writeLine(sprintf('  Point %s in circuit %s already', $aKey, $circuitKey));
                // Load group.
                $aGroup = $pointCircuits[$circuitKey];
                // Remove previous group.
                unset($pointCircuits[$circuitKey]);
            }

            $bGroup = [$details['b']];

            if (isset($circuitCache[$bKey])) {
                $circuitKey = $circuitCache[$bKey];
                $output->writeLine(sprintf('  Point %s in circuit %s already', $bKey, $circuitKey));
                // Load group.
                $bGroup = $pointCircuits[$circuitKey];
                // Remove previous group.
                unset($pointCircuits[$circuitKey]);
            }

            // Merge together into new group.
            $group = array_merge($aGroup, $bGroup);
            $pointCircuits[$nextCircuitId] = $group;
            $output->writeLine(sprintf('  Creating circuit group %s with %s points', $nextCircuitId, count($group)));

            // Update cache.
            foreach ($group as $groupPoint) {
                $circuitCache[$points[$groupPoint]->__toString()] = $nextCircuitId;
            }
            if (count($pointCircuits) === 1 && count($pointCircuits[$nextCircuitId]) === $pointCount) {
                $output->writeLine('All points have been connected to the same group!');
                return $a->x() * $b->x();
            }

            $nextCircuitId++;

        }

        $output->writeLine(sprintf('After %d connections there are %d circuits.', $connectionLimit, count($circuitCache)));
        return -1;
    }
}