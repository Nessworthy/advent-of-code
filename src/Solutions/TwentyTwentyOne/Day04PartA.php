<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\Bingo\BingoBoard;
use Nessworthy\AoC\TwentyTwentyOne\InputTransformer\BingoNumberBoard;
use Nessworthy\AoC\TwentyTwentyOne\InputTransformer\BingoNumberDraw;

class Day04PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $numberGenerator = (new BingoNumberDraw)->createNumberDrawGenerator($input);

        // Force the number generator to read the first line.
        $numberGenerator->current();

        // Skip the next blank line.
        $input->readLine()->current();

        /** @var BingoBoard[] $boards */
        $boards = [];
        $boardGenerator = new BingoNumberBoard();
        while ($board = $boardGenerator->createNumberBoard($input)) {
            $boards[] = $board;
        }

        foreach ($numberGenerator as $number) {
            foreach ($boards as $boardIndex => $board) {
                $board->markNumber($number);

                if ($board->hasBingo()) {
                    $output->writeLine(sprintf('Board %d has bingo!', $boardIndex + 1));
                    $score = $board->getScore();
                    return $score * $number;
                }
            }
        }

        return '(No board hit bingo before the numbers were all used).';
    }
}
