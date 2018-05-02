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
        $return = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $moyLat . ',' . $moyLng . '&sensor=true_or_false&key='.API_KEY,false,stream_context_create($arrContextOptions));

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

    public static function suppr_accents($str, $encoding='utf-8'){
                $str=htmlentities($str,ENT_NOQUOTES,$encoding);
                $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
                $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
                $str = preg_replace('#&[^;]+;#', '', $str);
                return $str;
    }
}

class photo
{
    public static function deplacephoto($i, $ville, $pays, $image)
    {


        if (empty(glob("pictures/$pays")) && empty(glob("pictures/$pays/$ville"))) {
            mkdir("pictures/$pays");
            mkdir("pictures/$pays/$ville");

            rename("pictures/import/$image", "pictures/$pays/$ville/$image");
        } elseif (empty(glob("pictures/$pays/$ville"))) {
            mkdir("pictures/$pays/$ville", 0700);
            rename("pictures/import/$image", "pictures/$pays/$ville/$image");
        } else {
            if (glob("pictures/$pays/$ville")) {
                rename("pictures/import/$image", "pictures/$pays/$ville/$image");
            }
        }
    }
    public static function compressphoto($i,$image){
        $img = imagecreatefromjpeg("pictures/import/".$image);
        imagejpeg($img,"pictures/import/$image",50);
    }

    public static function compteur(){
        $files = glob('pictures/import/*.*');
        $compteur = count($files);
        return $compteur;
    }
    public static function delete(){
       $repertoire = opendir(__DIR__.'/pictures/import/');
        while($fichier =readdir($repertoire)){
            if($fichier !=".." and $fichier !="." and $fichier !=".gitkeep"){
                var_dump($fichier);
                unlink('pictures/import/'.$fichier);
            }
        }
    closedir($repertoire);
    }
    public static function CreateTableImage(){
        $d = opendir(__DIR__ . '/pictures/import');

        $tableau=[];
        while ($file = readdir($d)) {

            if($file !==".gitkeep" and $file!=='.' and $file!=='..') {
                $tableau[] = $file;
            }
        }

        return $tableau;
    }
}
class option{
    public static function numeroImage($numpic){

    if($numpic <=5){
        $numpic = $numpic + 1;
        return $numpic;
    }
    else{
        $numpic = 1;
        return $numpic;
    }
}
    public static function GenerrateArticle($donnees, $numpic){

        echo '<article class="style'.$numpic.'">
                    <span class="image">
                        <img src="pictures/phantom/pic0'.$numpic.'.jpg" alt="" />
                    </span>
                    <a href="generic.php?country='.$donnees.'">
                        <h2>' . $donnees. '</h2>
                        <div class="content">
                            <p>Voir et modifier les photos : ' . $donnees. '</p>
                        </div>
                    </a>
                </article>';
    }

    public static function Menu($reponse){
        $elements =array(
            array('href'=>'option.php','nom'=>'HOME'),
            array('href'=>'generic.php?variable=1','nom'=>'UPLOAD PHOTO', 'use'=>'Ajouter des photos'),
            array('href'=>'generic.php?variable=2','nom'=>'VIDER DOSSIER IMPORT ('.  photo::compteur().' photo(s))','use'=>'Supprime les photos qui sont dans le dossier import'),
            array('href'=>'generic.php?variable=3','nom'=>'BASE DE DONNEE', 'use'=>'afficher et modifier la base de donnée')
        );
        while($donnees = $reponse->fetch()){
            $elements[] = array('href' => 'generic.php?country=' . $donnees['country'] . '',
                    'nom' => strtoupper($donnees['country']),
                    'use' => 'Voir et modifier les photos : ' . strtoupper($donnees['country']) . '');
        }

        return $elements;

    }

    public static function tableauCity($reponse, $country){
        $elements=array();

            while ($donnees = $reponse->fetch()) {

                $elements[] = array('href' => 'generic.php?country=' . $country . '&amp;city=' . $donnees['city'] . '',
                    'nom' => strtoupper($donnees['city']),
                    'use' => 'Voir et modifier les photos : ' . strtoupper($donnees['city']) . '');
            }

        return $elements;

    }

    public static function tableauImage($valeur, $country, $city)
    {
        $elements = array();
        While ($donnees = $valeur->fetch()) {
            $elements[] = array(

                'nom' => $donnees['image'],
                'cible' => 'pictures/' . $country . '/' . $city . '/' . $donnees['image'] . '',
                'endroit' => str_replace('_', ' ', $donnees['endroit']),
                'description' => $donnees['description']

            );
        }
        return $elements;


    }

}
