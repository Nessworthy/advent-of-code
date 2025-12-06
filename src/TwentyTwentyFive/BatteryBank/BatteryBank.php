<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFive\BatteryBank;

class BatteryBank {
    /**
     * @var int[]
     */
    private array $batteries = [];
    public function __construct(string $line)
    {
        $this->batteries = array_map('toInt', str_split($line));
    }

    /**
     * Get the largest found joltage from the battery bank.
     * @param int $fromBatteries The number of batteries to consider.
     * @return int The joltage value.
     */
    public function getLargestJoltage(int $fromBatteries): int {
        $batteryCount = count($this->batteries);

        /**
         * @var $currentJoltage int[]
         */
        $currentJoltage = [];

        for (
            $fromIndex = 0, $currentBattery = 0, $endIndex = 1 + $batteryCount - $fromBatteries;
            $currentBattery < $fromBatteries;
            $currentBattery++, $endIndex++
        ) {
            for (
                $highestJoltage = 0, $highestJoltagePosition = 0, $position = $fromIndex;
                $position < $endIndex;
                $position++
            ) {
                $joltage = $this->batteries[$position];
                if ($joltage > $highestJoltage) {
                    $highestJoltage = $joltage;
                    $highestJoltagePosition = $position;
                    if ($highestJoltage === 9) {
                        break;
                    }
                }
            }
            $currentJoltage[$currentBattery] = $highestJoltage;
            $fromIndex = $highestJoltagePosition + 1;
        }

        return (int) implode('', $currentJoltage);
    }
}