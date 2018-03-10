<?php
class BDD{
    public static function appelBDD(){
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        return $bdd;
    }


    public static function addpicutreBDD($bdd, $image,$moyLat,$moyLng,$city,$country,$endroit,$description){
        for($i=0;$i<=count($image)-1;$i++){

            $reponse =$bdd->prepare("SELECT count(*) AS nbr FROM information WHERE image=?");
            $reponse->execute(array($image[$i]));
            $req = $reponse->fetch(PDO::FETCH_ASSOC);

            if($req['nbr']==0){
                $req=$bdd->prepare('INSERT INTO information(image, lat, lng, city, country, endroit, description) VALUES(:image,:lat,:lng,:city,:country,:endroit,:description)');
                $req ->execute(array(
                    'image'=>$image[$i],
                    'lat'=>$moyLat,
                    'lng'=>$moyLng,
                    'city'=>$city,
                    'country'=>$country,
                    'endroit'=>$endroit,
                    'description'=>$description

                ));
            }

        }

    }
    public static function selectallBDD($bdd){
        $reponse = $bdd->query("SELECT * FROM information");

        while($donnees = $reponse ->fetch())
        {
            $tableauGPS[] = array($donnees['id'],
                $donnees['lat'],
                $donnees['lng'],
                $donnees['country'],
                $donnees['city'],
                $donnees['endroit'],
                $donnees['description'],
                $donnees['image']);

        }
        return $tableauGPS;
    }

    public static function findpictures($bdd, $variable) {
        $reponse = $bdd->query('SELECT * FROM information WHERE endroit=\''. $variable .'\'');
        return $reponse;
    }
}



