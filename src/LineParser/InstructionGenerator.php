<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\LineParser;

use Nessworthy\AoC2020\BootCode\Operation\Accumulate;
use Nessworthy\AoC2020\BootCode\Operation\Jump;
use Nessworthy\AoC2020\BootCode\Operation\NoOperation;
use Nessworthy\AoC2020\BootCode\Operation\Operation;
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
