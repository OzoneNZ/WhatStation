<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     *  Visible attributes
     */
    protected $visible = [
        'name'
    ];


    /**
     *  Getter for route key attribute
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
