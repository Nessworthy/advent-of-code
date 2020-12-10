<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\BootCode\Machine;
use Nessworthy\AoC2020\BootCode\OperationPointer;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\InstructionGenerator;

class Day8PartA implements Solution
{
    public function __construct(private Machine $machine, private InstructionGenerator $instructionGenerator)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        foreach ($input->readLine() as $line) {
            $this->machine->writeOperation($this->instructionGenerator->generate($line));
        }

        $result = $this->machine->execute(new \stdClass(), new OperationPointer(), Machine::FLAG_STOP_AT_RECURSION);

        $output->writeLine((string) $result->acc);
        return $result->acc;
    }

}
