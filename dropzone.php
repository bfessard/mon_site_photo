
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');
$bdd=BDD::appelBDD();
if(isset($_GET['value'])){
    if(isset($_GET['image']) and $_GET['Reupload']='Reupload'){
        $Newimage = photo::CreateTableImage();


        if($Newimage[2] !== $_GET['image']) {
            BDD::replaceImage($bdd, $Newimage[2], $_GET['image']);
        }
        photo::compressphoto(2,$Newimage[2]);
        photo::deplacephoto(2,$_GET['city'],$_GET['country'] ,$Newimage[2]);
    }
}
header('Location: option.php');
?>


