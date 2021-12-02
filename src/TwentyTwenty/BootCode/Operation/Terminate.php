<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\BootCode\Operation;

use Nessworthy\AoC\TwentyTwenty\BootCode\OperationPointer;
use stdClass;

class Terminate implements Operation
{
    public function execute(stdClass $state, OperationPointer $pointer): bool
    {
        return false;
    }
}
