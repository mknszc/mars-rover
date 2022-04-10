<?php

namespace App\Repositories;

use App\Enums\CommandEnum;
use App\Enums\DirectionEnum;

class DirectionRepository
{
    private $new_position;

    public function finder($position, $rotation)
    {
        if ($position == DirectionEnum::NORT) {
            if ($rotation == CommandEnum::LEFT) {
                $this->new_position = DirectionEnum::WEAST;
            } else if ($rotation == CommandEnum::RIGHT) {
                $this->new_position = DirectionEnum::EAST;
            }
        } else if ($position == DirectionEnum::SOUTH) {
            if ($rotation == CommandEnum::LEFT) {
                $this->new_position = DirectionEnum::EAST;
            } else if ($rotation == CommandEnum::RIGHT) {
                $this->new_position = DirectionEnum::WEAST;
            }
        } else if ($position == DirectionEnum::EAST) {
            if ($rotation == CommandEnum::LEFT) {
                $this->new_position = DirectionEnum::NORT;
            } else if ($rotation == CommandEnum::RIGHT) {
                $this->new_position = DirectionEnum::SOUTH;
            }
        } else if ($position == DirectionEnum::WEAST) {
            if ($rotation == CommandEnum::LEFT) {
                $this->new_position = DirectionEnum::SOUTH;
            } else if ($rotation == CommandEnum::RIGHT) {
                $this->new_position = DirectionEnum::NORT;
            }
        }

        return $this->new_position;
    }
}