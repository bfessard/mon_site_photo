<?php
include('const.inc.php');
include('fcts_fichier.php');
include('fcts_bdd.php');
if(isset($_POST['endroit']) & isset($_POST['description'])) {

    // recherche le fichier et compte le nombre de photo
    $files = glob(__DIR__.'pictures/import/*.*');
    $compteur = count($files);

    // récupération des noms de photos avec coordonées GPS
    $ligne = 0;
    if ($compteur !== 0) {
        $d = opendir(__DIR__ . '/pictures/import');


        while ($file = readdir($d)) {
            $tableau[] = $file;

        }
        for ($i = 1; $i <= $compteur + 1; $i++) {
            $mystring = $tableau[$i];

            if (strpos($mystring, ".JPG") !== false OR strpos($mystring, ".PNG") !== false) {
                $imageURL = "pictures/import/$tableau[$i]";


                $imgLocation = GPS::get_image_location($imageURL);

                if (isset($imgLocation['latitude'])) {
                    $image[] = $tableau[$i];
                    $imgLat[] = $imgLocation['latitude'];
                    $imgLng[] = $imgLocation['longitude'];
                }
            }
        }

        $moyLat = GPS::moyGPS($imgLat);
        $moyLng = GPS::moyGPS($imgLng);

        $city = GPS::findcity($moyLat, $moyLng);
        $country = GPS::findcountry($moyLat, $moyLng);
        $endroit = $_POST['endroit'];
        $description = $_POST['description'];

        for ($ii = 0; $ii < count($image); $ii++) {

            BDD::addpicutreBDD($image, $moyLat, $moyLng, $city, $country, $endroit, $description);
            photo::compressphoto($ii,$image);
            photo::deplacephoto($ii, $city, $country, $image);
        }

    }
}
header('Location: dropzone.php');


