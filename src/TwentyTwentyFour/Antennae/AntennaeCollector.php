<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\Antennae;

use Nessworthy\AoC\Grid\Grid;

class AntennaeCollector {
    public function collectAntennaePoints(Grid $grid): array {
        $antennae = [];
        foreach ($grid->traverseFromTopLeft() as $point => $value) {
            if ($value !== '.') {
                if (!isset($antennae[$value])) {
                    $antennae[$value] = [];
                }
                $antennae[$value][] = $point;
            }
        }
        return $antennae;
    }
}
