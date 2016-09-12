<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /**
     *  Visible attributes
     */
    protected $visible = [
        'genre',
        'image_url',
        'name',
        'regions',
        'region_frequencies',
        'web_url',
        'wiki_title'
    ];


    /**
     *  Appended attributes
     */
    protected $appends = [
        'regions',
        'region_frequencies',
    ];


    /**
     *  Appended relationships
     */
    protected $with = [
        'genre'
    ];


    /**
     *  Frequencies relationship
     */
    public function frequencies()
    {
        return $this->hasMany(Frequency::class);
    }


    /**
     *  Genre relationship
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }


    /**
     *  Region relationship
     */
    public function regions()
    {
        return $this->frequencies()
            ->join('regions', 'frequencies.region_id', '=', 'regions.id')
            ->orderBy('regions.name', 'asc')
            ->select('regions.name')
            ->distinct();
    }


    /**
     *  Fetch station list with frequencies removed
     */
    public static function getStationList()
    {
        $stations = static::join('genres', 'stations.genre_id', '=', 'genres.id')
            ->orderBy('genres.rank', 'asc')
            ->orderBy('stations.name', 'asc')
            ->select('stations.*')
            ->get();

        $stations = $stations->each(function ($station) {
            $station->makeHidden('region_frequencies');
        });

        return $stations;
    }


    /**
     *  Getter for regions attribute
     */
    public function getRegionsAttribute()
    {
        return $this->regions()->get()->pluck('name');
    }


    /**
     *  Getter for bands attribute
     */
    public function getRegionFrequenciesAttribute()
    {
        $map = [];

        foreach ($this->frequencies as $frequency) {
            // Fetch region and city associated with the frequency
            $region = $frequency->region->name;
            $city = $frequency->city->name;

            // Create region array index
            if (!array_key_exists($region, $map)) {
                $map[$region] = [];
            }

            // Create city array index
            if (!array_key_exists($city, $map[$region])) {
                $map[$region][$city] = [];
            }

            $map[$region][$city][] = $frequency;
        }

        return $map;
    }


    /**
     *  Retrieve frequencies for a specific region
     */
    public function getFrequenciesForRegion(Region $region)
    {
        return $this->frequencies()
            ->join('cities', 'cities.id', '=', 'frequencies.city_id')
            ->where('frequencies.region_id', $region->id)
            ->orderBy('cities.name', 'desc')
            ->get();
    }


    /**
     *  Getter for route key attribute
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
