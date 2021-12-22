<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\InputTransformer;

use Nessworthy\AoC\Common\Input;

class PolymerTemplate
{
    public function create(Input $input): array {
        $originalString = '';
        $rules = [];

        foreach ($input->readLine() as $i => $line) {
            if (empty($line)) {
                continue;
            }
            if ($i === 0) {
                $originalString = $line;
                continue;
            }
            [$adjacent, $toInsert] = explode(' -> ', $line);

            $rules[$adjacent] = $toInsert;
        }
        return [$originalString, $rules];
    }
}
