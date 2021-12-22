<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne;

use RuntimeException;

class BITSParser
{
    private const TYPE_SUM_SUBPACKETS = 0;
    private const TYPE_PRODUCT_OF_SUBPACKETS = 1;
    private const TYPE_MIN_OF_SUBPACKETS = 2;
    private const TYPE_MAX_OF_SUBPACKETS = 3;
    private const TYPE_LITERAL_VALUE = 4;
    private const TYPE_GT = 5;
    private const TYPE_LT = 6;
    private const TYPE_EQ = 7;

    private const LITERAL_VALUE_LAST_GROUP = '0';

    public function parsePacket(string $message, int $pointerPosition = 0): array {
        $packetVersion = bindec(substr($message, $pointerPosition, 3));

        $pointerPosition += 3;

        $typeId = bindec(substr($message, $pointerPosition, 3));
        $pointerPosition += 3;

        if ($typeId === self::TYPE_LITERAL_VALUE) {
            [$number, $pointerPosition] = $this->getLiteralNumber($message, $pointerPosition);
            return [$number, $pointerPosition, $packetVersion];
        }

        $lengthTypeId = (int) $message[$pointerPosition];
        ++$pointerPosition;

        if ($lengthTypeId === 1) {
            $numberOfSubPackets = bindec(substr($message, $pointerPosition, 11));
            $pointerPosition += 11;

            [$number, $position, $innerPacketVersion] = $this->readSubPackets(
                substr($message, $pointerPosition),
                0,
                $numberOfSubPackets,
                $typeId
            );

        } else {
            $totalLengthOfSubPackets = bindec(substr($message, $pointerPosition, 15));
            $pointerPosition += 15;

            [$number, $position, $innerPacketVersion] = $this->readSubPackets(
                substr($message, $pointerPosition, $totalLengthOfSubPackets),
                0,
                null,
                $typeId
            );
        }

        return [$number, $pointerPosition + $position, $innerPacketVersion + $packetVersion];
    }

    private function readSubPackets(
        string $message,
        int $pointerPosition,
        int $limitSubPackets = null,
        int $typeId
    ): array {

        $currentSubPacketIndex = 0;
        $subPacketNumbers = [];
        $packetVersion = 0;

        while (($limitSubPackets === null || $currentSubPacketIndex < $limitSubPackets) && $pointerPosition < strlen($message)) {
            ++$currentSubPacketIndex;
            [$number, $pointerPosition, $innerPacketVersion] = $this->parsePacket($message, $pointerPosition);
            $subPacketNumbers[] = $number;
            $packetVersion += $innerPacketVersion;
        }

        $packetNumber = 0;

        switch ($typeId) {
            case self::TYPE_SUM_SUBPACKETS:
                $packetNumber = array_sum($subPacketNumbers);
                break;
            case self::TYPE_PRODUCT_OF_SUBPACKETS:
                $packetNumber = array_product($subPacketNumbers);
                break;
            case self::TYPE_MIN_OF_SUBPACKETS:
                $packetNumber = min($subPacketNumbers);
                break;
            case self::TYPE_MAX_OF_SUBPACKETS:
                $packetNumber = max($subPacketNumbers);
                break;
            case self::TYPE_LITERAL_VALUE:
                throw new RuntimeException("Subpacket operation cannot be interpreted as a literal value.");
            case self::TYPE_GT:
                $packetNumber = $subPacketNumbers[0] > $subPacketNumbers[1] ? 1 : 0;
                break;
            case self::TYPE_LT:
                $packetNumber = $subPacketNumbers[0] < $subPacketNumbers[1] ? 1 : 0;
                break;
            case self::TYPE_EQ:
                $packetNumber = $subPacketNumbers[0] === $subPacketNumbers[1] ? 1 : 0;
                break;
            default:
                throw new RuntimeException("Type ID not recognised: " . $typeId);
        }

        return [$packetNumber, $pointerPosition, $packetVersion];
    }

    private function getLiteralNumber(string $packet, int $pointerPosition): array {
        $numberAsBinary = '';

        while (true) {
            if ($pointerPosition >= strlen($packet)) {
                throw new RuntimeException('Attempted to read literal number past packet length.');
            }
            $segment = substr($packet, $pointerPosition, 5);
            $pointerPosition += 5;

            $numberAsBinary .= substr($segment, 1);

            if ($segment[0] === self::LITERAL_VALUE_LAST_GROUP) {
                break;
            }
        }

        return [bindec($numberAsBinary), $pointerPosition];
    }
}
