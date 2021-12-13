<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day12PartA implements Solution
{

    private const END_TILE = 'end';
    private const START_TILE = 'start';

    public function solve(Input $input, Output $output): int|string
    {
        $map = [];

        foreach ($input->readLine() as $line) {
            [$from, $to] = explode('-', $line, 2);
            if (!isset($map[$from])) {
                $map[$from] = [];
            }

            if (!isset($map[$to])) {
                $map[$to] = [];
            }

            $map[$from][] = $to;
            $map[$to][] = $from;
        }

        $paths = 0;

        foreach ($this->getNextSteps($map, self::START_TILE, [], []) as $path) {
            $output->writeLine(implode(' > ', $path));
            ++$paths;
        }

        return $paths;
    }

    private function getNextSteps(array $map, string $current, array $path, array $travelled): Generator {
        $travelled[$current] = true;
        $path[] = $current;

        foreach ($map[$current] as $next) {

            if ($next === self::END_TILE) {
                $path[] = $next;
                yield $path;
                continue;
            }

            if (empty($map[$next])) {
                continue;
            }

            if (isset($travelled[$next]) && strtoupper($next) !== $next) {
                continue;
            }

            yield from $this->getNextSteps($map, $next, $path, $travelled);
        }
    }
}

