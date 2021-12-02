<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

interface Solution
{
    public function solve(Input $input, Output $output): int|string;
}
