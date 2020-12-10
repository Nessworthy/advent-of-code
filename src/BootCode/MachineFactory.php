<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\BootCode;

class MachineFactory
{
    public function create(): Machine
    {
        return new Machine();
    }
}
