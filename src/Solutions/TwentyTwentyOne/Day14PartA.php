<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\InputTransformer\PolymerTemplate;
use Nessworthy\AoC\TwentyTwentyOne\PolymerBuilder;

class Day14PartA implements Solution
{
    private PolymerTemplate $polymerTemplate;
    private PolymerBuilder $polymerBuilder;

    public function __construct(PolymerTemplate $polymerTemplate, PolymerBuilder $polymerBuilder)
    {
        $this->polymerTemplate = $polymerTemplate;
        $this->polymerBuilder = $polymerBuilder;
    }

    public function solve(Input $input, Output $output): int|string
    {
        [$originalString, $rules] = $this->polymerTemplate->create($input);

        $letterCounts = $this->polymerBuilder->buildAndFetchElementQuantities(
            $originalString, $rules, 10
        );

        return max($letterCounts) - min($letterCounts);
    }
}

