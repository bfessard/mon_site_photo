<?php
include('const.inc.php');
include('fcts_fichier.php');
include('fcts_bdd.php');

//if(isset($_POST['endroit']) & isset($_POST['description'])) {


    // recherche le fichier et compte le nombre de photo
    $compteur= photo::compteur();
    var_dump($compteur);
    
    // récupération des noms de photos avec coordonées GPS
    $ligne = 0;
    if ($compteur !== 0) {

        $tableau = photo::CreateTableImage();


        for ($i = 0; $i <= $compteur-1 ; $i++) {

            $mystring = $tableau[$i];



            if (strpos($mystring, ".JPG") !== false OR strpos($mystring, ".PNG") !== false) {
                $imageURL = "pictures/import/$tableau[$i]";

                $image[] = $tableau[$i];

                $imgLocation = GPS::get_image_location($imageURL);

                if (isset($imgLocation['latitude'])) {

                    $imgLat[] = $imgLocation['latitude'];
                    $imgLng[] = $imgLocation['longitude'];

                }

            }
        }

        if($_POST['imgLng']!='' and $_POST['imgLat']!=''){
            var_dump('coucou');
            $moyLat = floatval($_POST['imgLat']);
            $moyLng = floatval($_POST['imgLng']);
        }
        else
        {
            var_dump($imgLat);
            $moyLat = GPS::moyGPS($imgLat);
            $moyLng = GPS::moyGPS($imgLng);
        }



        $city = GPS::findcity($moyLat, $moyLng);

        $country = GPS::findcountry($moyLat, $moyLng);


        $endroit = str_replace(' ','_',$_POST['endroit']);
        $description = str_replace("'","\'",$_POST['description']);
        unset($i);
        for ($i = 0; $i < count($image); $i++) {
            $bdd = BDD::appelBDD();

            BDD::addpicutreBDD($bdd,$image[$i], $moyLat, $moyLng, $city, $country, $endroit, $description);
            photo::compressphoto($i,$image[$i]);
            photo::deplacephoto($i, $city, $country, $image[$i]);
        }

    }
header('Location: option.php');


