<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\BootCode\Operation;

use Nessworthy\AoC2020\BootCode\OperationPointer;
use stdClass;

interface Operation {
    public function execute(stdClass $state, OperationPointer $pointer): bool;
}
