<?php

namespace App\Repositories;

use App\Enums\CommandEnum;
use App\Enums\DirectionEnum;

class MoveRepository
{
    protected $directionRepository;
    protected $new_position;
    protected $rover_x_cord;
    protected $rover_y_cord;
    protected $x_cord;
    protected $y_cord;

    public function __construct(DirectionRepository $directionRepository)
    {
        $this->directionRepository = $directionRepository;
    }

    public function move($request)
    {
        $chars = str_split($request->commands);

        $this->new_position = $request->direction;
        $this->rover_x_cord = $request->start_cord_x;
        $this->rover_y_cord = $request->start_cord_y;
        $this->x_cord       = $request->cord_x;
        $this->y_cord       = $request->cord_y;

        foreach($chars as $char) {
            if (CommandEnum::LEFT == $char OR CommandEnum::RIGHT == $char) {
                $this->new_position = $this->directionRepository->finder($this->new_position, $char);
            }

            if (CommandEnum::MOVE == $char) {
                if ($this->new_position == DirectionEnum::NORT) {
                    if ($this->rover_x_cord + 1 <= $this->x_cord) {
                        $this->rover_x_cord += 1;
                    }
                } else if ($this->new_position == DirectionEnum::SOUTH) {
                    if ($this->rover_x_cord - 1 >= 0) {
                        $this->rover_x_cord -= 1;
                    }
                } else if ($this->new_position == DirectionEnum::EAST) {
                    if ($this->rover_y_cord + 1 <= $this->y_cord) {
                        $this->rover_y_cord += 1;
                    }
                } else if ($this->new_position == DirectionEnum::WEAST) {
                    if ($this->rover_y_cord - 1 >= 0) {
                        $this->rover_y_cord -= 1;
                    }
                }
            }
        }

        return array(
            'cord_x' => $this->rover_x_cord,
            'cord_y' => $this->rover_y_cord,
            'direction' => $this->new_position
        );
    }
}