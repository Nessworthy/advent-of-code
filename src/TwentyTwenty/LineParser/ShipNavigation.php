<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class ShipNavigation
{
    private const MOVE_NORTH = 'N';
    private const MOVE_SOUTH = 'S';
    private const MOVE_EAST = 'E';
    private const MOVE_WEST = 'W';
    private const TURN_LEFT = 'L';
    private const TURN_RIGHT = 'R';
    private const MOVE_FORWARD = 'F';

    public function compute(Input $input, Output $output): int|float
    {
        $position = [0,0];
        $faceModifier = [1,0];
        $facing = 0;

        $facingModifiers = [
            self::TURN_LEFT => -1,
            self::TURN_RIGHT => 1
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
                    $position[0] += $amount * $faceModifier[0];
                    $position[1] += $amount * $faceModifier[1];
                    break;
                case self::TURN_LEFT:
                case self::TURN_RIGHT:
                    $facing = ($facing + $amount * $facingModifiers[$instruction]) % 360;
                    $faceModifier[0] = cos(deg2rad($facing));
                    $faceModifier[1] = sin(deg2rad($facing));
                    break;
            }
            $output->writeLine($line);
            $output->writeLine(sprintf('%d/%d (%d [%d/%d])', $position[0], $position[1], $facing, $faceModifier[0], $faceModifier[1]));

        }
        return array_sum(array_map('abs', $position));
    }
}
