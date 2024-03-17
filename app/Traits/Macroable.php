<?php

namespace App\Traits;

trait Macroable
{
    private static array $macros = [];

    public static function macro(string $name, $macro): void
    {
        static::$macros[$name] = $macro;
    }

    public function hasMacro($method): bool
    {
        return isset(static::$macros[$method]);
    }

    public function __call($method, $arguments)
    {
        if (!static::hasMacro($method)) {
            return parent::__call($method, $arguments);
        }

        $macro = static::$macros[$method];

        if ($macro instanceof \Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $arguments);
        }
        return call_user_func_array($macro, $arguments);
    }
}
