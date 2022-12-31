<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\CrateStack;

class CrateStack {

    /**
     * @var string[]
     */
    private $stack = [];

    /**
     * @param string[] $stack
     * @return void
     */
    public function add(array $stack): void {
        $this->stack = array_merge($this->stack, $stack);
    }

    /**
     * @param int $number
     * @return string[]
     */
    public function pop(int $number): array {
        return array_splice($this->stack, -$number);
    }

    public function getTopCrate(): string {
        return $this->stack[count($this->stack) - 1];
    }
}
