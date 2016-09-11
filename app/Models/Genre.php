<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     *  Visible fields
     */
    protected $visible = [
        'name',
        'rank'
    ];
}
