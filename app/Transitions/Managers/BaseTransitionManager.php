<?php

namespace App\Transitions\Managers;

use App\Interfaces\TransitionManagers\BaseTransitionManagerInterface;

abstract class BaseTransitionManager implements BaseTransitionManagerInterface
{
    public static array $transitions = [];
}
