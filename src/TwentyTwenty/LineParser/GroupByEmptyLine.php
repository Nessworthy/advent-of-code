<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

use Generator;
use Nessworthy\AoC\Common\Input;

class GroupByEmptyLine
{
    public function parse(Input $input): Generator
    {
        $collected = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                yield $collected;
                $collected = [];
                continue;
            }
            $collected[] = $line;
        }
        if ($collected) {
            yield $collected;
        }
    }
}
