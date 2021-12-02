<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\BootCode;

use Nessworthy\AoC\TwentyTwenty\BootCode\Operation\Operation;
use stdClass;

class Machine
{
    private array $operations = [];
    public const FLAG_STOP_AT_RECURSION = 0b1;

    public const EXIT_TERMINATED = 1;
    public const EXIT_RECURSION = 2;

    public function __construct()
    {
    }

    public function writeOperation(Operation $operation): void
    {
        $this->operations[] = $operation;
    }

    public function execute(stdClass $state, OperationPointer $operationPointer, int $flags = 0) {
        $keepGoing = true;
        $state->history = [];
        while ($keepGoing) {
            $pointer = $operationPointer->next();
            if ($flags & self::FLAG_STOP_AT_RECURSION && in_array($pointer, $state->history, true)) {
                $state->exit = self::EXIT_RECURSION;
                return $state;
            }
            $state->history[] = $pointer;
            $signal = $this->operations[$pointer]->execute($state, $operationPointer);
            if (!$signal) {
                $keepGoing = false;
            }
        }
        $state->exit = self::EXIT_TERMINATED;
        return $state;
    }
}
