<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    /**
     *  Visible attributes
     */
    protected $visible = [
        'band',
        'frequency'
    ];


    /**
     *  City relationship
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }


    /**
     *  Region relationship
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }


    /**
     *  Station relationship
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
