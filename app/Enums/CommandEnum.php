<?php

namespace App\Enums;

class CommandEnum
{
    const LEFT  = 'L';
    const RIGHT = 'R';
    const MOVE  = 'M';

    public static function toArray() {
        return array(static::LEFT, static::RIGHT, static::MOVE);
    }

    public static function toList() {
        return implode('', self::toArray());
    }
}