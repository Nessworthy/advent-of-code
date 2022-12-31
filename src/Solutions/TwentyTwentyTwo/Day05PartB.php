<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\CargoCrane\CargoCrane;
use Nessworthy\AoC\TwentyTwentyTwo\CrateStack\CrateStack;
use Nessworthy\AoC\TwentyTwentyTwo\NumberRange\NumberRange;

class Day05PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {

        $lines = $input->readLine();
        $line = $lines->current();
        $layout = [];
        $craneStacks = [];

        while ($line !== '') {
            $layout[] = $line;
            $lines->next();
            $line = $lines->current();
        }

        $craneLine = array_pop($layout);
        $matches = [];
        preg_match_all('#\d+#', $craneLine, $matches, PREG_OFFSET_CAPTURE);

        $layout = array_reverse($layout);

        foreach ($matches[0] as [$craneId, $offset]) {
            $key = ((int) $craneId) - 1;
            $craneStacks[$key] = new CrateStack();
        }

        foreach ($layout as $itemLine) {
            foreach ($matches[0] as [$craneId, $offset]) {
                if (($itemLine[$offset] ?? ' ') !== ' ') {
                    $key = ((int) $craneId) - 1;
                    $craneStacks[$key]->add([$itemLine[$offset]]);
                }
            }
        }

        $crane = new CargoCrane(...$craneStacks);

        // Skip past empty line.
        $lines->next();

        while ($line = $lines->current()) {
            $lines->next();

            $matches = [];
            preg_match('#^move (\d+) from (\d+) to (\d+)$#', $line, $matches);

            [$count, $from, $to] = array_map('toInt', array_slice($matches, 1));
            $output->writeLine(sprintf('Moving %s from %s to %s', $count, $from, $to));
            $crane->move($count, $from, $to, false);
        }

        return $crane->getTopCrates();
    }
}

