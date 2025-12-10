<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions;

class Context {
    private bool $isTestRun;

    public function __construct(bool $isTestRun)
    {
        $this->isTestRun = $isTestRun;
    }

    public function isTestRun(): bool
    {
        return $this->isTestRun;
    }
}