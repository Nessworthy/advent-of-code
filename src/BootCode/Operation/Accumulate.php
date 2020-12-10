<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\BootCode\Operation;

use Nessworthy\AoC2020\BootCode\OperationPointer;
use stdClass;

class Accumulate implements Operation
{
    public function __construct(private int $value)
    {
    }

    public function execute(stdClass $state, OperationPointer $pointer): bool
    {
        $acc = $state->acc ?? 0;
        $acc += $this->value;
        $state->acc = $acc;
        return true;
    }

}
