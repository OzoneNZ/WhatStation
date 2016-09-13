<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Region;

class RegionController extends Controller
{
    /**
     *  Fetch all regions
     */
    public function regions()
    {
        return Region::all()->pluck('name');
    }
}
