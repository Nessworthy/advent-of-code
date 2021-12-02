<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

use Nessworthy\AoC\Common\Input;

class PassportScanner
{
    public function scanInput(Input $input)
    {
        $allFields = [];
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                yield $allFields;
                $allFields = [];
                continue;
            }
            $fieldsInLine = explode(' ', $line);
            foreach ($fieldsInLine as $rawFieldPair) {
                $fieldPair = explode(':', $rawFieldPair);
                $allFields[$fieldPair[0]] = $fieldPair[1];
            }
        }
        if (!empty($allFields)) {
            yield $allFields;
        }
    }
}
