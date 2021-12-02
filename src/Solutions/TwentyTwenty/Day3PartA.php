<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day3PartA implements Solution
{

    private const TREE = '#';
    private const HORIZONTAL_MOVE = 3;

    public function __construct()
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $trees = 0;
        $xPosition = 0;

        foreach ($input->readLine() as $line) {
            if ($this->isTreeAt($line, $xPosition)) {
                ++$trees;
            }
            $xPosition += self::HORIZONTAL_MOVE;
        }
        $output->writeLine((string) $trees);
        return $trees;
    }

    private function isTreeAt(string $line, int $position): bool
    {
        $tileSize = strlen($line);
        return $line[$position % $tileSize] === self::TREE;
    }

}
