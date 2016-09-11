<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Station;

class StationController extends Controller
{
    /**
     *  Fetch all stations
     */
    public function stations()
    {
        return Station::getStationList();
    }


    /**
     *  Fetch a specific station
     */
    public function station(Station $station)
    {
        return $station;
    }
}
