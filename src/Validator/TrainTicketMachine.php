<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Validator;

use Generator;

class TrainTicketMachine
{
    private array $allRules = [];
    private array $rulesByFieldName = [];
    private array $eliminatedFieldNamesByIndex = [];
    private array $indexesToFieldNames = [];

    private function mergeOrCreateRule(int $min, int $max): void
    {
        foreach ($this->allRules as $i => $rule) {
            [$ruleMin, $ruleMax] = $rule;
            if ($min >= $ruleMin && $max <= $ruleMax) {
                // Absorbed.
                return;
            }
            if ($min <= $ruleMin && $max >= $ruleMax) {
                $this->allRules[$i] = [$min, $max];
                $this->rejigRules();
                return;
            }
            if ($min < $ruleMin && $max >= $ruleMin) {
                $this->allRules[$i] = [$min, $ruleMax];
                $this->rejigRules();
                return;
            }
            if ($max > $ruleMax && $min < $ruleMax) {
                $this->allRules[$i] = [$ruleMin, $max];
                $this->rejigRules();
                return;
            }
        }
        $this->allRules[] = [$min, $max];
    }

    public function __construct(array $rules)
    {
        foreach ($rules as $fieldName => $fieldRules) {
            $this->rulesByFieldName[$fieldName] = $fieldRules;
            foreach ($fieldRules as $fieldRule) {
                [$min, $max] = $fieldRule;
                $this->mergeOrCreateRule($min, $max);
            }
        }
    }

    public function getInvalidValues(array $ticket): Generator
    {
        foreach ($ticket as $value) {
            $valid = false;
            foreach ($this->allRules as $rule) {
                [$min, $max] = $rule;
                if ($value >= $min && $value <= $max) {
                    $valid = true;
                    break;
                }
            }
            if (!$valid) {
                echo 'Invalid: ' . $value . "\n";
                yield $value;
            }
        }
    }

    private function rejigRules(): void
    {
        // Cannot be fooked to optimize this until I need to.
    }

    public function learn(array $ticketValues): void
    {
        foreach ($ticketValues as $index => $value) {
            if (isset($this->indexesToFieldNames[$index])) {
                continue;
            }
            if (!isset($this->eliminatedFieldNamesByIndex[$index])) {
                $this->eliminatedFieldNamesByIndex[$index] = [];
            }
            foreach ($this->rulesByFieldName as $fieldName => $rules) {
                if (in_array($fieldName, $this->eliminatedFieldNamesByIndex[$index], true)) {
                    continue;
                }
                foreach ($rules as $rule) {
                    [$min, $max] = $rule;
                    if ($value >= $min && $value <= $max) {
                        continue 2;
                    }
                }
                // We've reached here - the rules didn't validate.
                $this->eliminatedFieldNamesByIndex[$index][] = $fieldName;
            }
        }

        $this->checkRulesByElimination();
    }

    private function checkRulesByElimination(): void
    {
        $fieldNames = array_keys($this->rulesByFieldName);
        $numberOfFields = count($fieldNames);
        $changes = false;

        // TODO: If needed, maybe look at pairs of 2, triples of 3, etc.

        foreach ($fieldNames as $name) {
            if (in_array($name, $this->indexesToFieldNames, true)) {
                continue;
            }

            $eliminatedFrom = [];
            foreach ($this->eliminatedFieldNamesByIndex as $index => $fieldNamesEliminated) {
                if (in_array($name, $fieldNamesEliminated, true)) {
                    $eliminatedFrom[] = $index;
                }
            }
            if (count($eliminatedFrom) === $numberOfFields - 1) {
                $changes = true;
                $notEliminatedFrom = array_diff(array_keys($this->eliminatedFieldNamesByIndex), $eliminatedFrom);
                $notEliminatedFrom = current($notEliminatedFrom);
                $this->indexesToFieldNames[$notEliminatedFrom] = $name;
                // May as well fully mark the field as not in use.
                $this->eliminatedFieldNamesByIndex[$notEliminatedFrom] = $fieldNames;
            }
        }

        if ($changes) {
            $this->checkRulesByElimination();
        }
    }

    /**
     * @return array
     */
    public function getIndexesToFieldNames(): array
    {
        return $this->indexesToFieldNames;
    }
}
