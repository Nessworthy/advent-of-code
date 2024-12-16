<?php declare(strict_types=1);

namespace Nessworthy\AoC\Queue;

class RepeatingQueueGenerator {
    public function generate(array $items): \Generator {
        while (true) {
            foreach ($items as $item) {
                yield $item;
            }
        }
    }

}
