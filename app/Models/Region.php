<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Region extends Model
{
    /**
     *  Cities relationship
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }


    /**
     *  Frequencies relationship
     */
    public function frequencies()
    {
        return $this->hasMany(Frequency::class);
    }


    /**
     *  Fetch frequencies and stations within the region
     */
    public function getWithinRegion()
    {
        // Fetch region frequencies, sorted by ascending station name
        $map = [];
        $frequencies = $this->frequencies()
            ->join('stations', 'stations.id', '=', 'frequencies.station_id')
            ->orderBy('stations.name', 'asc')
            ->get();

        foreach ($frequencies as $frequency) {
            // Fetch region and city associated with the frequency
            $city = $frequency->city;
            $station = $frequency->station;

            // Create city array index
            if (!array_key_exists($city->name, $map)) {
                $map[$city->name] = [];
            }

            // Create station array index
            if (!array_key_exists($station->name, $map[$city->name])) {
                $map[$city->name][$station->name] = [
                    'station' => $station->makeHidden('region_frequencies'),
                    'frequencies' => []
                ];
            }

            // Push frequency into station frequency list
            $map[$city->name][$station->name]['frequencies'][] = $frequency;
        }

        return $map;
    }


    /**
     *  Stations relationship
     */
    public function stations()
    {
        return Station::select('stations.*')
            ->join('frequencies', 'frequencies.station_id', '=', 'stations.id')
            ->join('genres', 'genres.id', '=', 'stations.genre_id')
            ->where('frequencies.region_id', $this->id)
            ->orderBy('genres.rank', 'asc')
            ->orderBy('stations.name');
    }


    /**
     *  Getter for route key attribute
     */
    public function getRouteKeyName()
    {
        return 'name';
    }


    /**
     *  Getter for stations relationship
     */
    public function getStationsAttribute()
    {
        $stations = $this->stations()->get();
        $stations = $stations->each(function ($station, $key) {
            $station->frequencies = $station->getFrequenciesForRegion($this);
        });

        return $stations;
    }
}
