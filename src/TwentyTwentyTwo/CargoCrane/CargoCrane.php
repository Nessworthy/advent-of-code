<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\CargoCrane;

use Nessworthy\AoC\TwentyTwentyTwo\CrateStack\CrateStack;

class CargoCrane {

    /**
     * @var CrateStack[]
     */
    private array $crateStacks;

    public function __construct(CrateStack ...$crateStacks) {
        $this->crateStacks = $crateStacks;
    }

    public function move(int $count, int $from, int $to, bool $oneAtATime): void {
        $stacks = $this->crateStacks[$from - 1]->pop($count);
        if ($oneAtATime) {
            $stacks = array_reverse($stacks);
        }
        $this->crateStacks[$to - 1]->add($stacks);
    }

    public function getTopCrates(): string {
        return implode(
            '',
            array_map(static fn (CrateStack $crateStack) => $crateStack->getTopCrate(), $this->crateStacks)
        );
    }
}
