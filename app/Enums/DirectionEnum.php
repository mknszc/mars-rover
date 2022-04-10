<?php

namespace App\Enums;

final class DirectionEnum
{
    const NORT  = 'N';
    const SOUTH = 'S';
    const EAST  = 'E';
    const WEAST = 'W';

    public static function toArray() {
        return array(static::NORT, static::SOUTH, static::EAST, static::WEAST);
    }

    public static function toList() {
        return implode(',', self::toArray());
    }
}