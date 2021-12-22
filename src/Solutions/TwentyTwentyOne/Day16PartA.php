<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\BITSParser;
use Nessworthy\AoC\TwentyTwentyOne\InputTransformer\BITSPacketReader;
use RuntimeException;

class Day16PartA implements Solution
{
    private BITSParser $BITSParser;
    private BITSPacketReader $BITSPacketReader;

    public function __construct(BITSPacketReader $BITSPacketReader, BITSParser $BITSParser)
    {
        $this->BITSPacketReader = $BITSPacketReader;
        $this->BITSParser = $BITSParser;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $answers = [];

        foreach($this->BITSPacketReader->readPacketsFromInput($input) as $packet) {
            [$number, $pointer, $versionNumber] = $this->BITSParser->parsePacket($packet);
            $answers[] = $versionNumber;
        }

        return implode("\n", $answers);
    }
}
