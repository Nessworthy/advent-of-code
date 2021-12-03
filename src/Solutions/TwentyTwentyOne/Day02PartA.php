<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day02PartA implements Solution
{
    private const OPERATION_FORWARD = 'forward';
    private const OPERATION_DOWN = 'down';
    private const OPERATION_UP = 'up';

    public function solve(Input $input, Output $output): int|string
    {
        $depth = 0;
        $positionX = 0;

        foreach ($input->readLine() as $command) {
            [$operation, $amount] = explode(' ', $command, 2);
            $amount = (int) $amount;

            switch ($operation) {
                case self::OPERATION_DOWN:
                    $depth += $amount;
                    break;
                case self::OPERATION_UP:
                    $depth -= $amount;
                    break;
                case self::OPERATION_FORWARD:
                    $positionX += $amount;
                    break;
                default:
                    $output->writeLine(sprintf('Unknown command: "%s"', $command));
            }
        }
        return $depth * $positionX;
    }
}
