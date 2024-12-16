<?php declare(strict_types=1);

class Brainfuck {
    public function test(\Nessworthy\AoC\Common\Input $input): string {
        /**
         * Adds 48 to current slot
         */
        $add48 = '>++++++[<++++++++>-]<';
        /**
         * Adds 57 to current slot
         */
        $add57 = '>++++++[<+++++++++>-]<+++';
        $fullInput = '123';


        /**
         * Read input
         * d = Digit count
         * o = output slot
         * While input is between 48 (0) and 57 (9):
         *  Increment d
         *  Store number in slot[d]
         *  Subtract 48 from slot[d]
         */
        $readNumber = '';

        /**
         * 0: 0
         * 1: Reserved
         * 2: 48
         * 3: 57
         *
         * 10:
         */
        $code = ">>$add48>$add57>>>>>>>$readNumber";
        return (new \dotzero\Brainfuck($code, $fullInput))->run(true);
    }
}
