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


            $reponse =$bdd->prepare("SELECT count(*) AS nbr FROM information WHERE image=?");
            $reponse->execute(array($image));
            $req = $reponse->fetch(PDO::FETCH_ASSOC);

            if($req['nbr']==0){
                $req=$bdd->prepare('INSERT INTO information(image, lat, lng, city, country, endroit, description) VALUES(:image,:lat,:lng,:city,:country,:endroit,:description)');
                $req ->execute(array(
                    'image'=>$image,
                    'lat'=>$moyLat,
                    'lng'=>$moyLng,
                    'city'=>$city,
                    'country'=>$country,
                    'endroit'=>$endroit,
                    'description'=>$description

                ));
            }
    }
    public static function selectallBDD($bdd){

        $reponse = $bdd->query("SELECT DISTINCT lat, lng, country, city, endroit, description FROM information  ORDER BY  endroit ASC ");


        while($donnees = $reponse ->fetch())
        {

            $tableauGPS[] = array(
                $donnees['lat'],
                $donnees['lng'],
                $donnees['country'],
                $donnees['city'],
                $donnees['endroit'],
                $donnees['description']);

        }

        return $tableauGPS;
    }

    public static function findpictures($bdd, $variable) {
        $reponse = $bdd->query('SELECT  image FROM information  WHERE endroit=\''. $variable .'\'LIMIT 1');
        return $reponse;
    }
    public static function selectcountryBDD($bdd)
    {
        $reponse = $bdd->query("SELECT DISTINCT country FROM information ORDER BY country  ASC ");
        return $reponse;
    }
    public static function selectcityBDD($bdd, $country){

        $reponse = $bdd->query('SELECT DISTINCT city FROM information WHERE country=\''.$country.'\'ORDER BY city ASC');
        return $reponse;
    }
    public static function selectimage($bdd,$city){
        $reponse =$bdd->query('SELECT image, endroit, description FROM information WHERE city=\''.$city.'\'ORDER BY image ASC');
        return $reponse;
    }

    public static function selectValue($bdd,$nom){
        $reponse =$bdd->query('SELECT image, city, country, endroit, description FROM information WHERE image=\''.$nom.'\'');
        return $reponse;
    }

    public static function replaceImage($bdd,$newImage, $oldImage){
        $bdd->exec('UPDATE information SET image=\''.$newImage.'\' WHERE image=\''.$oldImage.'\'');
    }

    public static function replaceEndroit($bdd,$newEndroit,$oldEndroit){
        $bdd->exec('UPDATE information SET endroit=\''.$newEndroit.'\' WHERE endroit=\''.$oldEndroit.'\'');
    }
    public static function replaceDescription($bdd,$newDescription,$oldDescription){
        $bdd->exec('UPDATE information SET description=\''.$newDescription.'\' WHERE description=\''.$oldDescription.'\'');
    }
    public static function deleteImage($bdd,$image){
        $bdd->exec('DELETE FROM information WHERE image=\''.$image.'\'');
    }

}



