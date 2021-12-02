<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day10PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $adapters = [];

        foreach ($input->readLine() as $line) {
            $adapters[] = (int) $line;
        }

        sort($adapters);

        $routes = 1;

        // First we want to split the paths by ones it knows it needs to go through
        foreach($this->splitAdaptersIntoGroups($adapters) as $group) {
            var_dump($group);
            $amt = $this->recursivelyDetermineNumberOfRoutes($group);
            $routes *= $amt;
            $output->writeLine((string) $amt . ' (' . $routes . ')');
        }

        return $routes;
    }

    private function splitAdaptersIntoGroups(array $adapters): \Generator
    {
        array_unshift($adapters, 0);
        $adapters = array_flip($adapters);
        $group = [];

        foreach ($adapters as $adapter => $unused) {
            $potentialAdapters = [];
            if (isset($adapters[$adapter + 1])) {
                $potentialAdapters[] = $adapter + 1;
            }
            if (isset($adapters[$adapter + 2])) {
                $potentialAdapters[] = $adapter + 2;
            }
            if (isset($adapters[$adapter + 3])) {
                $potentialAdapters[] = $adapter + 3;
            }
            $combinations = count($potentialAdapters);
            if ($combinations > 1) {
                $group[] = $adapter;
                array_push($group, ...$potentialAdapters);
            } elseif ($combinations === 1 && count($group)) {
                $group[] = $adapter;
                $group = array_unique($group);
                sort($group);
                yield $group;
                $group = [];
            }
        }
    }

    private function recursivelyDetermineNumberOfRoutes(array $adapters, $currentRoute = []): int
    {
        $adapter = array_shift($adapters);
        $currentRoute[] = $adapter;
        if (!$adapters) {
            // echo 'Route: ' . implode(' > ', $currentRoute) . "\n";
            return 1;
        }

        $adapters = array_values($adapters);
        $routes = 0;

        foreach([1,2,3] as $increment) {
            $nextHop = array_search($adapter + $increment, $adapters, true);
            if ($nextHop !== false) {
                // echo $adapter . ' -> ' . ($adapter + $increment) . "\n";
                $routes += $this->recursivelyDetermineNumberOfRoutes(
                    array_slice($adapters, (int) $nextHop),
                    $currentRoute
                );
            }
        }

        return $routes;
    }

}
