<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Common;
use Nessworthy\AoC\Grid\Grid;

class InputAdapter {
    public function toGrid(Input $input): Grid {
        return new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );
    }
}
