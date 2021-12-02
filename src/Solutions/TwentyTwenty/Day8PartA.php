<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwenty\BootCode\Machine;
use Nessworthy\AoC\TwentyTwenty\BootCode\OperationPointer;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\InstructionGenerator;
use stdClass;

class Day8PartA implements Solution
{
    public function __construct(private Machine $machine, private InstructionGenerator $instructionGenerator)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        foreach ($input->readLine() as $line) {
            $this->machine->writeOperation($this->instructionGenerator->generate($line));
        }

        $result = $this->machine->execute(new stdClass(), new OperationPointer(), Machine::FLAG_STOP_AT_RECURSION);

        $output->writeLine((string) $result->acc);
        return $result->acc;
    }

}
