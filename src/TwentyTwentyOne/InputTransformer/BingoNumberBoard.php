<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\InputTransformer;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\TwentyTwentyOne\Bingo\BingoBoard;

class BingoNumberBoard
{
    public function createNumberBoard(Input $input): ?BingoBoard
    {
        $grid = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                break;
            }
            $grid[] = array_values(array_map(
                'toInt',
                array_filter(
                    explode(' ', $line),
                    static function($x) { return $x !== ''; }
                )
            ));
        }
        if (empty($grid)) {
            return null;
        }
        return new BingoBoard($grid);
    }
}
