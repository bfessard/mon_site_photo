
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');
$bdd=BDD::appelBDD();
if(isset($_GET['value'])){

    if(isset($_GET['image']) and $_GET['value']='Reupload'){
        $Newimage = photo::CreateTableImage();
        var_dump($_GET['image']);
        var_dump($Newimage[2]);
        if($Newimage[2] !== $_GET['image']) {
            BDD::replaceImage($bdd, $Newimage[2], $_GET['image']);
        }
        photo::compressphoto(2,$Newimage[2]);
        photo::deplacephoto(2,$_GET['city'],$_GET['country'] ,$Newimage[2]);
    }
}

?>


