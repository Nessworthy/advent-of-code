<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class ShipBeaconNavigation
{
    private const MOVE_NORTH = 'N';
    private const MOVE_SOUTH = 'S';
    private const MOVE_EAST = 'E';
    private const MOVE_WEST = 'W';
    private const ROTATE_LEFT = 'L';
    private const ROTATE_RIGHT = 'R';
    private const MOVE_FORWARD = 'F';

    public function compute(Input $input, Output $output): int|float
    {
        $position = [10, -1];
        $moved = [0,0];

        $rotationModifiers = [
            self::ROTATE_LEFT => [1, -1],
            self::ROTATE_RIGHT => [-1, 1], // [a,b] > [-b,a]
        ];

        $directionModifiers = [
            self::MOVE_NORTH => [0, -1],
            self::MOVE_SOUTH => [0, 1],
            self::MOVE_WEST => [-1, 0],
            self::MOVE_EAST => [1, 0]
        ];

        foreach ($input->readLine() as $line)
        {
            $instruction = $line[0];
            $amount = (int) substr($line, 1);

            switch ($instruction) {
                case self::MOVE_NORTH:
                case self::MOVE_SOUTH:
                case self::MOVE_EAST:
                case self::MOVE_WEST:
                    $position[0] += $amount * $directionModifiers[$instruction][0];
                    $position[1] += $amount * $directionModifiers[$instruction][1];
                    break;
                case self::MOVE_FORWARD:
                    /*foreach ($position as $i => $value) {
                        if (abs($value) > 0) {
                            $mod = $value <=> 0;
                            $position[$i] = $value - (min(abs($value), $amount) * $mod);
                        }
                    }*/
                    $moved[0] += $amount * $position[0];
                    $moved[1] += $amount * $position[1];
                    break;
                case self::ROTATE_LEFT:
                case self::ROTATE_RIGHT:
                    $times = abs($amount / 90);
                    while ($times > 0) {
                        $times--;
                        $position = [
                            $position[1] * $rotationModifiers[$instruction][0],
                            $position[0] * $rotationModifiers[$instruction][1]
                        ];
                    }
                    break;
            }
            $output->writeLine($line);
            $output->writeLine(sprintf('%d/%d (%d, %d)', $position[0], $position[1], $moved[0], $moved[1]));

        }
        return array_sum(array_map('abs', $moved));
    }
}
