<?php

namespace App\Http\Controllers;

use App\Repositories\PlateauRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PlateauController extends Controller
{
    protected $plateauRepository;

    public function __construct(PlateauRepository $plateauRepository)
    {
        $this->plateauRepository = $plateauRepository;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|min:3|max:255',
            'cord_x' => 'required|int|min:1|max:300',
            'cord_y' => 'required|int|min:1|max:300'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        if ($request->cord_x != $request->cord_y) {
            return response()->json([
                'message' => 'Coordinates must be equal',
            ], 400);
        }

        if ($this->plateauRepository->check($request->name)) {
            return response()->json([
                'message'       => 'Plateau Here',
                'name'          => $request->name,
                'coordinate'    => $this->plateauRepository->get($request->name)
            ], 200);
        }

        $this->plateauRepository->create($request->name, $request->cord_x, $request->cord_y);

        return response()->json([
            'message'       => 'Plateau Created',
            'name'          => $request->name,
            'coordinate'    => $this->plateauRepository->get($request->name)
        ], 201);
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

        if (!$this->plateauRepository->check($request->name)) {
            return response()->json([
                'message' => 'Plateau Not Found',
            ], 400);
        }

        return response()->json([
            'message'       => 'Plateau Here',
            'name'          => $request->name,
            'coordinate'    => $this->plateauRepository->get($request->name)
        ], 200);
    }
}