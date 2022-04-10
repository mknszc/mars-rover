<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class PlateauRepository
{
    private $prefix = 'Pleteau';

    public function create($name, $x, $y)
    {
        Cache::put($this->prefix . $name, array('cord_x' => $x, 'cord_y' => $y));

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

    public function checkIn($name, $x, $y)
    {
        if (!self::check($name)) {

            return False;
        }

        if ($x > $this->getMaxPlaneX($name)) {

            return False;
        }

        if ($y > $this->getMaxPlaneY($name)) {

            return False;
        }

        return True;
    }

    public function getMaxPlaneY($name)
    {
        $plateau = Cache::get($this->prefix . $name);

        return $plateau['cord_y'];
    }

    public function getMaxPlaneX($name)
    {
        $plateau = Cache::get($this->prefix . $name);

        return $plateau['cord_x'];
    }
}