<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Region;

class FrequencyController extends Controller
{
    /**
     *  Fetch all stations within a region
     */
    public function region(Region $region)
    {
        return $region->getWithinRegion();
    }
}
