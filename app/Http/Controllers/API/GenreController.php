<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Genre;

class GenreController extends Controller
{
    /**
     *  Fetch all genres
     */
    public function genres()
    {
        return Genre::orderBy('rank', 'asc')->get()->pluck('name');
    }
}
