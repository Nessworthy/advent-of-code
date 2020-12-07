<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Validator;

class PassportChecker
{

    private const RULES = [
        'byr' => '(?:192[0-9]|19[3-9][0-9]|200[0-2])',
        'iyr' => '(?:201[0-9]|2020)',
        'eyr' => '(?:202[0-9]|2030)',
        'hgt' => '(?:(?:1[5-8][0-9]|19[0-3])cm|(?:59|6[0-9]|7[0-6])in)',
        'hcl' => '\#[0-9a-f]{6}',
        'ecl' => '(?:amb|blu|brn|gry|grn|hzl|oth)',
        'pid' => '\d{9}'
    ];

    public function validate(array $passport): bool
    {
        foreach (self::RULES as $key => $rule) {
            if (!isset($passport[$key])) {
                return false;
            }

            if (!preg_match('#^' . $rule . '$#', $passport[$key])) {
                return false;
            }
        }

        return true;
    }
}
