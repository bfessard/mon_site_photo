<?php
class GPS{
    public static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
            return 0;
        if(count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

    public static function get_image_location($image = '')
    {
        $exif = exif_read_data($image, 0, true);

        if($exif && isset($exif['GPS']['GPSLatitude']))
        {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude    = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude   = $exif['GPS']['GPSLongitude'];



            $lat_degrees = count($GPSLatitude) > 0 ? GPS::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? GPS::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? GPS::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? GPS::gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? GPS::gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? GPS::gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return false;
        }
    }

    public static function moyGPS($valGPS)
    {
        $sommeGPS=0;
        $i =0;
        foreach($valGPS as $cle=>$valeur)
        {
            $i++;
            $sommeGPS += $valeur;
        }
        $moyenne =$sommeGPS/$i;
        return $moyenne;
    }

    public static function file_get_contents($moyLat, $moyLng){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $return = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $moyLat . ',' . $moyLng . '&sensor=true_or_false&key=AIzaSyACcynPu83SEga6WA9DTJFnGbFg-LDC_Z0',false,stream_context_create($arrContextOptions));
        var_dump($return);
        $test = json_decode($return, true);
        return $test;

    }

    public static function findcity($moyLat, $moyLng)
    {
        $test = GPS::file_get_contents($moyLat, $moyLng);

        $count = count($test['results']['0']['address_components']);
        for ($a = 0; $a < $count; $a++) {
            if ($test['results']['0']['address_components'][$a]['types']['0'] == "locality") {
                $ville = $test['results']['0']['address_components'][$a]['long_name'];
                return $ville;
            }
        }
    }

    public static function findcountry($moyLat, $moyLng)
    {
        $test = GPS::file_get_contents($moyLat, $moyLng);
        $count = count($test['results']['0']['address_components']);

        for ($a = 0; $a < $count; $a++) {

            if ($test['results']['0']['address_components'][$a]['types']['0'] == "country") {
                $pays = $test['results']['0']['address_components'][$a]['long_name'];
                return $pays;
            }
        }
    }
}

class photo
{
    public static function deplacephoto($i, $ville, $pays, $image)
    {

        if (empty(glob("pictures/$pays")) && empty(glob("pictures/$pays/$ville"))) {
            mkdir("pictures/$pays");
            mkdir("pictures/$pays/$ville");

            rename("pictures/import/$image[$i]", "pictures/$pays/$ville/$image[$i]");
        } elseif (empty(glob("pictures/$pays/$ville"))) {
            mkdir("pictures/$pays/$ville", 0700);
        } else {
            if (!glob("pictures/$pays/$ville/$image[$i]")) {
                rename("pictures/import/$image[$i]", "pictures/$pays/$ville/$image[$i]");
            }
        }
    }
    public static function compressphoto($ii,$image){
        $img = imagecreatefromjpeg("pictures/import/".$image[$ii]);
        imagejpeg($img,"pictures/import/$image[$ii]",50);
    }
}
