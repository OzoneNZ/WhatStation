<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Frequency;
use App\Models\Station;
use App\Models\Region;

class StatisticsController extends Controller
{
    /**
     *  Fetch WhatStation statistics
     */
    public function statistics()
    {
        return [
            'frequencies' => Frequency::count(),
            'stations' => Station::count(),
            'regions' => Region::count()
        ];
    }
}
