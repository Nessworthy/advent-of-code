<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day3PartB implements Solution
{

    private const TREE = '#';

    public function __construct()
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $output->write((string) (
            $this->fetchNumberOfTreesHit(1, 1, $input) *
            $this->fetchNumberOfTreesHit(3, 1, $input) *
            $this->fetchNumberOfTreesHit(5, 1, $input) *
            $this->fetchNumberOfTreesHit(7, 1, $input) *
            $this->fetchNumberOfTreesHit(1, 2, $input)
        ));
        return 0;
    }

    private function isTreeAt(string $line, int $position): bool
    {
        $tileSize = strlen($line);
        return $line[$position % $tileSize] === self::TREE;
    }

    private function fetchNumberOfTreesHit(int $rightSpeed, int $downSpeed, Input $input): int
    {
        $input->reset();

        $trees = 0;
        $xPosition = 0;
        $yPosition = 0;

        foreach ($input->readLine() as $yPositionOfMap => $line) {
            if ($yPositionOfMap !== $yPosition) {
                continue;
            }
            if ($this->isTreeAt($line, $xPosition)) {
                ++$trees;
            }
            $xPosition += $rightSpeed;
            $yPosition += $downSpeed;
        }
        return $trees;
    }

}
