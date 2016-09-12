<?php
$dir = 'resources/data/';
$files = glob($dir . '*.txt');

$cities = [];
$freqs = [];
$stations = [];
$genres = [];

foreach ($files as $file) {
    $lines = file_get_contents($file);
    $lines = explode(PHP_EOL, $lines);

    $station = str_replace($dir, '', $file);
    $station = str_replace('.txt', '', $station);
    $data = [ 'name' => $station ];
    $region = '';

    foreach ($lines as $line) {
        $line = trim($line);
        if (!strlen($line)) {
            continue;
        }

        // Genre
        if ($line[0] == '*') {
            $data['genre'] = $genre = substr($line, 1);
            if (!in_array($genre, $genres)) {
                $genres[] = $genre;
            }
        }

        // Station data
        if ($line[0] == "/") {
            $line = explode(' ', $line);
            $prop = substr($line[0], 1);
            array_shift($line);
            $value = implode(' ', $line);

            $data[$prop] = $value;
        }

        // Region
        if ($line[0] == "#") {
            $region = substr($line, 1);
            if (!array_key_exists($region, $cities)) {
                $cities[$region] = [];
            }
        }

        // City + frequency
        if ($line[0] == "." && $region) {
            $parts = substr($line, 1);
            $parts = explode(' ', $parts);

            $freq = $parts[count($parts) - 1];
            array_pop($parts);
            $city = implode(' ', $parts);

            if (substr($freq, -3) == ' AM') {
                $band = 'AM';
                $freq = str_replace($band, '', $freq);
            } else {
                $band = 'FM';
            }

            if (!in_array($city, $cities[$region])) {
                $cities[$region][] = $city;
            }

            $freqs[] = [
                'station' => $station,
                'region' => $region,
                'city' => $city,
                'frequency' => $freq,
                'band' => $band
            ];

            //echo "REGION: " . $region . " | CITY: " . $city . " | FREQUENCY: " . $freq . PHP_EOL;
        }
    }

    $stations[$station] = $data;
}


/**
 *  Genre SQL
 */
foreach ($genres as $genre) {
    echo "INSERT INTO genres(name, rank) VALUES('" . addslashes($genre) . "', 1);" . PHP_EOL;
}


echo PHP_EOL;
echo PHP_EOL;


/**
 *  Region SQL
 */
foreach (array_keys($cities) as $region) {
    echo "INSERT INTO regions(name) VALUES('" . addslashes($region) . "');" . PHP_EOL;
}


echo PHP_EOL;
echo PHP_EOL;


/**
 *  City SQL
 */
foreach ($cities as $region => $cities) {
    foreach ($cities as $city) {
        echo "INSERT INTO cities(region_id, name) VALUES((SELECT id FROM regions WHERE regions.name = '" . addslashes($region) . "'), '" . addslashes($city) . "');" . PHP_EOL;
    }
}


echo PHP_EOL;
echo PHP_EOL;


/**
 *  Station SQL
 */
foreach ($stations as $station) {
    $keys = [ 'image_url', 'web_url' ];
    $skip = false;
    foreach ($keys as $key) {
        if (!array_key_exists($key, $station)) {
            $skip = true;
            break;
        }
    }

    if ($skip) {
        continue;
    }

    if (!array_key_exists('wiki_title', $station)) {
        $station['wiki_title'] = '';
    }

    echo "INSERT INTO stations(genre_id, name, image_url, web_url, wiki_title) ";
    echo "VALUES((SELECT id FROM genres WHERE genres.name = '" . addslashes($station['genre']) . "'), ";
    echo sprintf(
        "'%s', '%s', '%s', %s);",
        addslashes($station['name']),
        addslashes($station['image_url']),
        addslashes($station['web_url']),
        $station['wiki_title'] == '' ? 'NULL' : "'" . addslashes($station['wiki_title']) . "'"
    ) . PHP_EOL;
}


echo PHP_EOL;
echo PHP_EOL;


/**
 *  Frequencies SQL
 */
foreach ($freqs as $freq) {
    echo "INSERT INTO frequencies(station_id, region_id, city_id, frequency, band) ";
    echo "VALUES" . sprintf(
        "(%s, %s, %s, '%s', '%s')",
        "(SELECT id FROM stations WHERE stations.name = '" . addslashes($freq['station']) . "')",
        "(SELECT id FROM regions WHERE regions.name = '" . addslashes($freq['region']) . "')",
        "(SELECT id FROM cities WHERE cities.name = '" . addslashes($freq['city']) . "' AND cities.region_id = (SELECT id FROM regions WHERE regions.name = '" . addslashes($freq['region']) . "'))",
        addslashes($freq['frequency']),
        addslashes($freq['band'])
    ) . ";" . PHP_EOL;
}
