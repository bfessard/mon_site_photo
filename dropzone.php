
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');
$bdd=BDD::appelBDD();
if(isset($_GET['value'])){

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
    elseif($_GET['value']=='change'){


        $endroit = str_replace(' ','_',$_POST['endroit']);
        $description=str_replace("'","\'",$_POST['description']);
        var_dump($description);
        if($_POST['oldDescription']!= $_POST['description']){
            echo 'hello';
            BDD::replaceDescription($bdd, $description, $_POST['oldDescription']);
        }
        if($endroit != $_POST['oldEndroit']){
            echo 'coucou';
        BDD::replaceEndroit($bdd, $endroit, $_POST['oldEndroit']);
        }

    }

}
header('Location: option.php');
?>


