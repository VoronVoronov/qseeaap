<?php

namespace App\Transitions\Managers;

class ContractStatusTransition extends BaseTransitionManager
{
    public static array $transitions = [
        1 => [2, 3, 4],
        2 => [3, 4],
        3 => [],
        4 => []
    ];

    public static array $specialTransitions = [
        1 => [2, 3, 4],
        2 => [1, 3, 4],
        3 => [1, 2],
        4 => []
    ];

    public static function canTransition(mixed $oldValue, mixed $newValue, array $params = []): bool
    {
        $possibilities = self::$transitions[$oldValue];

        if (isset($params['has_agreement']) && $params['has_agreement'] === TRUE) {
            $possibilities = self::$specialTransitions[$oldValue];
        }

        if (in_array($newValue, $possibilities)) {
            return true;
        } else {
            return false;
        }
    }
}
