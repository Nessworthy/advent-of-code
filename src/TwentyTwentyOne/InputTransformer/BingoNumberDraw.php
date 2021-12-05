<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\InputTransformer;

use Generator;
use Nessworthy\AoC\Common\Input;

class BingoNumberDraw
{
    public function createNumberDrawGenerator(Input $input): Generator
    {
        $numberString = $input->readLine()->current();

        foreach (explode(',', $numberString) as $number) {
            yield (int) $number;
        }
    }
}
