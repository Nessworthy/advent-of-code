<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\Accumulate;
use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\Jump;
use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\NoOperation;
use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\Operation;
use RuntimeException;

class InstructionGenerator
{
    public function generate($line): Operation {
        $split = explode(' ', $line);
        switch ($split[0]) {
            case 'nop':
                return new NoOperation();
            case 'jmp':
                return new Jump((int) $split[1]);
            case 'acc':
                return new Accumulate((int) $split[1]);
        }
        throw new RuntimeException('Unknown operation: ' . $split[0]);
    }
}
