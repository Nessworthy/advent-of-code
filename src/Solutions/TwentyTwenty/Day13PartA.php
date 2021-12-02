<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day13PartA implements Solution
{

    public function __construct()
    {
    }

    private function removeOutOfServiceBusses($value): bool
    {
        return $value !== 'x';
    }

    public function modN($number, $mod): int
    {
        return $number % $mod;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $lines = $input->readLine();
        $time = (int) $lines->current();

        $fn = curry([$this, 'modN'], $time);
        $output->writeLine((string) $fn(939));

        $lines->next();
        $busses = explode(',', $lines->current());

        // Filter out busses with 'x' as they're out of service, or so we think.
        $busses = array_filter($busses, [$this, 'removeOutOfServiceBusses']);

        // Set the array keys of each bus to the bus ID.
        $busses = array_combine($busses, $busses);

        // For each bus, determine the number of minutes between the current time and the last time the bus ran.
        $busTimes = array_map(curry([$this, 'modN'], $time), $busses);

        // Then, for each bus, subtract the bus ID to determine the number of minutes after the current time the bus is due to arrive.
        foreach ($busTimes as $id => $time) {
            $busTimes[$id] = $id - $time;
        }

        // Sort all the bus times by their time-to-arrival, and pick the earliest one.
        asort($busTimes);
        $index = array_key_first($busTimes);

        return $index * $busTimes[$index];
    }
}
