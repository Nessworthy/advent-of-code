<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwenty\BootCode\Machine;
use Nessworthy\AoC\TwentyTwenty\BootCode\MachineFactory;
use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\Terminate;
use Nessworthy\AoC\TwentyTwenty\BootCode\OperationPointer;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\InstructionGenerator;
use RuntimeException;
use stdClass;

class Day8PartB implements Solution
{
    public function __construct(private MachineFactory $machineFactory, private InstructionGenerator $instructionGenerator)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $iteration = 0;
        $changed = true;
        while ($changed) {
            ++$iteration;
            $nthInstructionToChange = $iteration - 1;
            $changed = false;
            $input->reset();
            $machine = $this->machineFactory->create();
            foreach ($input->readLine() as $index => $line) {

                if (!$changed && !$nthInstructionToChange) {
                    if (str_starts_with($line, 'jmp')) {
                        $line = str_replace('jmp', 'nop', $line);
                        $changed = true;
                        $output->writeLine(sprintf('Pass %d: Changing instruction %d from jmp to nop', $iteration, $index));
                    } elseif (str_starts_with($line, 'nop')) {
                        $line = str_replace('nop', 'jmp', $line);
                        $changed = true;
                        $output->writeLine(sprintf('Pass %d: Changing instruction %d from nop to jmp', $iteration, $index));
                    }
                } else {
                    $nthInstructionToChange--;
                }

                $instruction = $this->instructionGenerator->generate($line);

                $machine->writeOperation($instruction);
            }

            $machine->writeOperation(new Terminate());

            $result = $machine->execute(new stdClass(), new OperationPointer(), Machine::FLAG_STOP_AT_RECURSION);

            if ($result->exit === Machine::EXIT_TERMINATED) {
                $output->writeLine('Machine terminated!');
                $output->writeLine((string) $result->acc);
                return $result->acc;
            }
            $output->writeLine('Machine terminated via. recursion.');
        }
        throw new RuntimeException('Answer not found.');
    }

}
