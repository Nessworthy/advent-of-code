<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\SnailMath;

class SnailMathOperations {
    public function sum(SnailNumber $left, SnailNumber $right): SnailNumber {
        $strLeft = (string) $left;
        $strRight = (string) $right;
        $result = sprintf(
            '%s%s%s%s%s',
            SnailNumber::GATE_OPEN,
            $strLeft,
            SnailNumber::NUMBER_SEP,
            $strRight,
            SnailNumber::GATE_CLOSE
        );

        $evaluatedResult = $this->evaluate($result);

        return new SnailNumber($evaluatedResult);
    }

    private function evaluate(string $snailNumber): string {

        $stillEvaluating = true;
        $stillExploding = true;
        $stillSplitting = true;
        $canSplit = false;
        $maxTicks = 10000;
        $tick = 0;

        while ($stillEvaluating && $tick < $maxTicks) {
            ++$tick;
            // echo "Tick " . $tick . "\n";

            if ($stillExploding) {
                $stillExploding = false;
            } elseif ($stillSplitting) {
                $canSplit = true;
                $stillSplitting = false;
            } else {
                $stillEvaluating = false;
            }

            $len = strlen($snailNumber);
            $depthStarts = [];
            $depthNumbers = [];
            $expectNumber = false;
            $collectedNumber = '';

            for ($pointer = 0, $depth = 0; $pointer < $len; ++$pointer) {
                $current = $snailNumber[$pointer];

                if ($expectNumber) {
                    if (is_numeric($current)) {
                        $collectedNumber .= $current;
                        continue;
                    }

                    $number = (int) $collectedNumber;

                    if (!isset($depthNumbers[$depth])) {
                        $depthNumbers[$depth] = [];
                    }

                    $startedAtPosition = $pointer - strlen($collectedNumber);

                    $depthNumbers[$depth][] = [
                        'number' => $number,
                        'position' => $startedAtPosition
                    ];

                    if ($number > 9 && $canSplit) {
                        $stillSplitting = true;
                        $stillExploding = true;
                        $canSplit = false;
                        // Split!
                        // echo 'SPLIT! @ ' . $pointer. ' in ' . $snailNumber . "\n";
                        $snailNumber = sprintf(
                            '%s%s%s%s%s%s%s',
                            substr($snailNumber, 0, $startedAtPosition),
                            SnailNumber::GATE_OPEN,
                            floor($number / 2),
                            SnailNumber::NUMBER_SEP,
                            ceil($number / 2),
                            SnailNumber::GATE_CLOSE,
                            substr($snailNumber, $pointer)
                        );
                        // echo 'Post split: ' . $snailNumber . "\n";
                        $stillEvaluating = true;
                        continue 2;
                    }
                    $collectedNumber = '';
                }

                switch ($current) {
                    case SnailNumber::GATE_OPEN:
                        ++$depth;
                        $expectNumber = true;
                        $depthStarts[$depth] = $pointer;
                        continue 2;
                    case SnailNumber::GATE_CLOSE:
                        if ($depth >= 5 && count($depthNumbers[$depth]) === 2) {
                            $stillExploding = true;
                            // Explode!
                            // echo 'EXPLODE! @ ' . $pointer. ' in ' . $snailNumber . "\n";
                            // Find the next right number.
                            [$number, $position] = $this->findNextNumber($snailNumber, $pointer);

                            if ($number !== null) {
                                $snailNumber = sprintf(
                                    '%s%s%s',
                                    substr($snailNumber, 0, $position),
                                    $number + $depthNumbers[$depth][1]['number'],
                                    substr($snailNumber, $position + 1 + (strlen((string) $number) - 1))
                                );
                            }

                            // Replace current depth with 0.
                            $snailNumber = sprintf(
                                '%s%s%s',
                                substr($snailNumber, 0, $depthStarts[$depth]),
                                '0',
                                substr($snailNumber, $pointer + 1)
                            );

                            // Find the next left number.
                            [$number, $position] = $this->findPrevNumber(
                                $snailNumber,
                                $depthNumbers[$depth][0]['position'] - 2
                            );

                            if ($number !== null) {
                                $newNumber = $number + $depthNumbers[$depth][0]['number'];
                                $snailNumber = sprintf(
                                    '%s%s%s',
                                    substr($snailNumber, 0, $position + 1),
                                    $newNumber,
                                    substr(
                                        $snailNumber,
                                        // Assuming it would have exploded if it was > 1 digit here.
                                        $position + strlen((string) $number) + 1
                                    )
                                );
                            }
                            // echo 'Post explode: ' . $snailNumber . "\n";
                            $stillEvaluating = true;
                            continue 3;
                        }
                        unset($depthStarts[$depth], $depthNumbers[$depth]);
                        --$depth;
                        continue 2;
                    case SnailNumber::NUMBER_SEP:
                        $expectNumber = true;
                }
            }

            if (isset($depth) && $depth !== 0) {
                throw new \RuntimeException('Depth at the end is incorrect! ' . $depth);
            }
        }

        return $snailNumber;
    }

    private function findNextNumber(string $str, int $fromPosition): array {
        $len = strlen($str);
        $numberAsStr = '';
        $started = false;
        $startPosition = false;
        for ($pointer = $fromPosition; $pointer < $len; ++$pointer) {
            if (is_numeric($str[$pointer])) {
                if (!$started) {
                    $started = true;
                    $startPosition = $pointer;
                }
                $numberAsStr .= $str[$pointer];
                continue;
            }
            if ($started) {
                return [(int) $numberAsStr, $startPosition];
            }
        }

        return [null, null];
    }

    private function findPrevNumber(string $str, int $fromPosition): array {
        $numberAsStr = '';
        $started = false;
        for ($pointer = $fromPosition; $pointer >= 0; --$pointer) {
            if (is_numeric($str[$pointer])) {
                if (!$started) {
                    $started = true;
                }
                $numberAsStr = $str[$pointer] . $numberAsStr;
                continue;
            }
            if ($started) {
                return [(int) $numberAsStr, $pointer];
            }
        }

        return [null, null];
    }

    public function calculateMagnitude(SnailNumber $snailNumberObj): int
    {
        $snailNumber = (string) $snailNumberObj;
        $len = strlen($snailNumber);

        $magnitude = 0;

        $currentNumberString = '';
        $matches = [];

        while (preg_match('#\[(?<left>\d+),(?<right>\d+)]#', $snailNumber, $matches, PREG_OFFSET_CAPTURE)) {
            $reduced = (((int) $matches['left'][0]) * 3) + (((int) $matches['right'][0]) * 2);
            $snailNumber = sprintf(
                '%s%d%s',
                substr($snailNumber, 0, $matches[0][1]),
                $reduced,
                substr($snailNumber, $matches[0][1] + strlen($matches[0][0]))
            );
        }
        return (int) $snailNumber;
    }

}
