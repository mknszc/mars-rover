<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class RoverRepository
{
    private $prefix = 'Rover';

    public function create($request)
    {
        Cache::put($this->prefix . $request->name,
            array(
                'cord_x'        => $request->start_cord_x,
                'cord_y'        => $request->start_cord_y,
                'direction'     => $request->direction,
                'plateau_name'  => $request->plateau_name
            )
        );

        return True;
    }

    public function get($name)
    {
        return Cache::get($this->prefix . $name);
    }

    public function check($name)
    {
        return (Cache::has($this->prefix . $name) ? True : False);
    }

    public function update($request)
    {
        self::create($request);

        return True;
    }
}