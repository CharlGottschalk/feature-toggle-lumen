<?php

namespace CharlGottschalk\FeatureToggleLumen\Traits;

use Illuminate\Support\Str;

trait SnakeTrait
{
    protected static function snake($value)
    {
        $value = str_replace(' ', '_', $value);
        return (string) Str::of($value)->lower()->snake();
    }

    protected static function snakeArray($array)
    {
        array_walk($array, function(&$item) {
            $value = str_replace(' ', '_', $item);
            $item = (string) Str::of($value)->lower()->snake();
        });
        return $array;
    }
}
