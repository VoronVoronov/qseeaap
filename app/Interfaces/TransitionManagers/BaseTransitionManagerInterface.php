<?php

namespace  App\Interfaces\TransitionManagers;

interface BaseTransitionManagerInterface
{
    public static function canTransition(mixed $oldValue, mixed $newValue, array $params = []): bool;
}
