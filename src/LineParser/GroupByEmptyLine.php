<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\LineParser;

use Generator;
use Nessworthy\AoC2020\Common\Input;

class GroupByEmptyLine
{
    public function parse(Input $input): Generator
    {
        $collected = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                yield $collected;
                $collected = [];
            }
            $collected[] = $line;
        }
        if ($collected) {
            yield $collected;
        }
    }
}
