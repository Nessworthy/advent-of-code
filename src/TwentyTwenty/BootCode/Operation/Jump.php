<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\BootCode\Operation;

use Nessworthy\AoC\TwentyTwenty\BootCode\OperationPointer;
use stdClass;

class Jump implements Operation
{
    public function __construct(private int $amount)
    {
    }

    public function execute(stdClass $state, OperationPointer $pointer): bool
    {
        $pointer->moveRelative($this->amount);
        return true;
    }

}
