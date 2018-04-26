
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');
$bdd=BDD::appelBDD();
if(isset($_GET['value']) and isset($_GET['image'])){

    if( $_GET['value']=='Reupload'){
        $Newimage = photo::CreateTableImage();

        if($Newimage[0] !== $_GET['image']) {
            BDD::replaceImage($bdd, $Newimage[0], $_GET['image']);
        }
        photo::compressphoto(0,$Newimage[0]);
        photo::deplacephoto(0,$_GET['city'],$_GET['country'] ,$Newimage[0]);
    }
    elseif($_GET['value']=='delete'){
        BDD::deleteImage($bdd,$_GET['image']);
        $dossier = opendir('pictures/'.$_GET['country'].'/'.$_GET['city'].'');
        While($file=readdir($dossier)){
            if($file==$_GET['image']){
                unlink($dossier.'/'.$file);
            }
        }
    }
}
header('Location: option.php');
?>


