<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\InputTransformer;

use Generator;
use Nessworthy\AoC\Common\Input;

class BITSPacketReader
{
    public function readPacketsFromInput(Input $input): Generator
    {
        foreach ($input->readLine() as $hexEncodedMessage) {

            $convertToBase16 = rcurry('base_convert', 16, 2);
            $pad = rcurry('str_pad', 4, '0', STR_PAD_LEFT);

            yield implode(
                '',
                array_map(
                    $pad,
                    array_map(
                        $convertToBase16,
                        str_split($hexEncodedMessage)
                    )
                )
            );
        }
    }
}
