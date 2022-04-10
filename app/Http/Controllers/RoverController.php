<?php

namespace App\Http\Controllers;

use App\Repositories\PlateauRepository;
use App\Repositories\RoverRepository;
use App\Repositories\MoveRepository;
use App\Enums\DirectionEnum;
use App\Enums\CommandEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoverController extends Controller
{
    protected $roverRepository, $plateauRepository, $moveRepository;

    public function __construct(
        RoverRepository     $roverRepository,
        PlateauRepository   $plateauRepository,
        MoveRepository      $moveRepository
    )
    {
        $this->roverRepository      = $roverRepository;
        $this->plateauRepository    = $plateauRepository;
        $this->moveRepository       = $moveRepository;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|min:3|max:255',
            'plateau_name' => 'required|string|min:3|max:255',
            'start_cord_x' => 'required|int|min:0|max:300',
            'start_cord_y' => 'required|int|min:0|max:300',
            'direction'    => 'required|in:' . DirectionEnum::toList()
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        if (!$this->plateauRepository->check($request->plateau_name)) {
            return response()->json([
                'message' => 'Plateau Not Found',
            ], 400);
        }

        if (!$this->plateauRepository->checkIn(
            $request->plateau_name, $request->start_cord_x, $request->start_cord_y)
        ) {
            return response()->json([
                'message' => 'Start coordinate must be inside plateau',
            ], 400);
        }

        if ($this->roverRepository->check($request->name)) {
            return response()->json([
                'message'   => 'Rover Here',
                'name'      => $request->name,
                'info'      => $this->roverRepository->get($request->name)
            ], 200);
        }

        $this->roverRepository->create($request);

        return response()->json([
            'message'   => 'Rover Created',
            'name'      => $request->name,
            'info'      => $this->roverRepository->get($request->name)
        ], 200);
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        if (!$this->roverRepository->check($request->name)) {
            return response()->json([
                'message' => 'Rover Not Found',
            ], 400);
        }

        return response()->json([
            'message'   => 'Rover Here',
            'name'      => $request->name,
            'info'      => $this->roverRepository->get($request->name)
        ], 200);
    }

    public function sendCommand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:3|max:255',
            'commands'  => 'required|regex:/^[' . CommandEnum::toList() .'\s]+$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        if (!$this->roverRepository->check($request->name)) {
            return response()->json([
                'message' => 'Rover Not Found',
            ], 400);
        }

        $rover   = $this->roverRepository->get($request->name);
        $plateau = $this->plateauRepository->get($rover['plateau_name']);

        $requestArray = (object) array(
            'cord_x'        => $plateau['cord_x'],
            'cord_y'        => $plateau['cord_y'],
            'start_cord_x'  => $rover['cord_x'],
            'start_cord_y'  => $rover['cord_y'],
            'direction'     => $rover['direction'],
            'commands'      => $request->commands
        );

        $new_position = $this->moveRepository->move($requestArray);

        $requestRover = (object) array(
            'name'         => $request->name,
            'plateau_name' => $rover['plateau_name'],
            'start_cord_x' => $new_position['cord_x'],
            'start_cord_y' => $new_position['cord_y'],
            'direction'    => $new_position['direction']
        );

        $this->roverRepository->update($requestRover);

        return response()->json([
            'message' => 'Rover state change',
        ], 200);
    }
}
