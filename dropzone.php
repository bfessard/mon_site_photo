
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');
$bdd=BDD::appelBDD();
if(isset($_GET['value'])){

    if(isset($_GET['image']) and $_GET['value']='Reupload'){
        $Newimage = photo::CreateTableImage();

        if($Newimage[0] !== $_GET['image']) {
            BDD::replaceImage($bdd, $Newimage[0], $_GET['image']);
        }
        photo::compressphoto(0,$Newimage[0]);
        photo::deplacephoto(0,$_GET['city'],$_GET['country'] ,$Newimage[0]);
    }
}
header('Location: option.php');
?>


