<!DOCTYPE HTML>
<?php include('fcts_fichier.php');
include('fcts_bdd.php');
include('const.inc.php');

$bdd = BDD::appelBDD();

?>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Generic - Phantom by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/JS/phantom/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/phantom/main.css" />
    <link href="assets/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/phantom/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/phantom/ie8.css" /><![endif]-->
</head>
<body>
<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <div class="inner">

            <!-- Logo -->
            <a href="option.php" class="logo">
                <span class="symbol"><img src="pictures/phantom/logo.svg" alt="" /></span><span class="title">Phantom</span>
            </a>

            <!-- Nav -->
            <nav>
                <ul>
                    <li><a href="#menu">Menu</a></li>
                </ul>
            </nav>

        </div>
    </header>

    <!-- Menu -->
    <nav id="menu">
        <h2>Menu</h2>
        <ul>
            <?php
            $reponse = BDD::selectcountryBDD($bdd);

            foreach(option::Menu($reponse) as $element){?>

                <li><a href="<?php echo $element['href'];?>"><?php echo $element['nom'];?></a></li>
            <?php }

            ?>
        </ul>
    </nav>
    <!-- Main -->
    <div id="main">
        <div class="inner">


            <?php

            if(isset($_GET['variable'])) {

                switch ($_GET['variable']) {
                    case 1: ?>
                        <h1>UPLOAD PHOTO</h1>
                <form action="upload.php" class="dropzone"></form>
                <form method="post" action="afficher_photo.php" >
                    <div class ="row uniform">

                        <div class="6u 12u$(xsmall)">
                        <input id="endroit" name="endroit" value="" placeholder="Endroit" type="text">
                        </div>
                        <div class="textarea-wrapper">
                        <textarea id="description" name="description" placeholder="Description du lieu" style="overflow: hidden; resize:none;width: 650px;height:79px "></textarea>
                        </div>
                        <div class="12u$">
                            <ul class="actions">
                                <li>
                                <input class="special" value="Upload" type="submit">
                                </li>
                            </ul>
                        </div>
                    </div>
                </form> <?php

                        break;
                    case 2:

                        photo::delete();
                        header('Location: option.php');
                        break;

                    case 3:?>
                      <section>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Pays</th>
                                        <th>Ville</th>
                                        <th>Endroit</th>
                                        <th>Description</th>
                                        <th>Nom</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $image="DSC00037.JPG";
                                    foreach(BDD::selectallBDD($bdd) as $element){?>
                                        <tr>
                                            <?php for($i=1; $i<=7;$i++){ ?>
                                                <td><?php echo $element[$i]; ?></td>
                                           <?php }?>
                                        </tr>
                                    <?php }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <?php
                        break;
                }
            }
            elseif(isset($_GET['country']) and isset($_GET['city'])==false){?>
            <header><h1><?php echo $_GET['country'];?></h1></header>
            <section class="tiles">

                <?php $numeroImage = 1;
                $reponse = BDD::selectcityBDD($bdd, $_GET['country']);
                foreach(option::tableauCity($reponse,$_GET['country']) as $element){?>

                <article class="style<?php echo $numeroImage; ?>">
                    <span class="image">
                            <img src="pictures/phantom/pic0<?php echo $numeroImage; ?>.jpg" alt="" />
                    </span>
                    <a href="<?php echo $element['href'];?>">
                        <h2><?php echo $element['nom']; ?></h2>
                        <div class ="content">
                            <p><?php echo $element['use']; ?></p>
                        </div>
                    </a>
                </article>

                <?php $numeroImage = option::numeroImage($numeroImage);}
            echo '</section>';
                unset($reponse);unset($element);
            }
                elseif(isset($_GET['country']) and isset($_GET['city'])){?>
                <header><h1><?php echo $_GET['city'];?></h1></header>
                <div class="row uniform">
                    <section class="tiles">

                    <br/>
                    <?php $numeroImage =1;
                    $valeur = BDD::selectimage($bdd,$_GET['city']);
                    foreach(option::tableauImage($valeur,$_GET['country'],$_GET['city']) as $element){?>


                            <article class="style">
                                <span class="image">
                                    <img src="<?php if(is_file($element['cible'])){echo $element['cible'];}else{echo'pictures/phantom/pic0'.$numeroImage.'';} ?>" alt=""/>
                                </span>
                                <a href="generic.php?nom=<?php echo $element['nom'];?>">
                                    <h2><?php  echo $element['nom'];?></h2>

                                    <div class ="content">
                                        <p><?php echo $element['endroit'];?></p>

                                    </div>
                                </a>

                            </article>

                        <?php $numeroImage = option::numeroImage($numeroImage);}?></section>
                    <br/>
                    <ul class="actions vertical small">
                        <li>
                            <a class="button special small" href="generic.php?country=<?php echo $_GET['country'];?>"> Retour</a>
                        </li>
                    </ul>
                <?php }
                elseif(isset($_GET['nom'])) {
                    $reponse = BDD::selectValue($bdd,$_GET['nom']);
                    while($donnees = $reponse->fetch()){;?>

                        <header><h1><?php echo $donnees['image'];?></h1></header>
                        <p>
                                    <span class="image left">
                                        <img src="<? echo 'pictures/'.$donnees['country'].'/'.$donnees['city'].'/'.$_GET['nom'].''; ?>" alt="">
                                    </span>


                                    <form action="upload.php" class="dropzone" style="display: inline-block; margin-top: 4px;border-radius: 4px"></form>

                                    <ul class="actions">
                                        <li>
                                            <a href="dropzone.php?value=Reupload&amp;image=<?php echo $_GET['nom'];?>&amp;country=<?php echo $donnees['country'];?>&amp;city=<?php echo $donnees['city'];?>" id="test" class="button special small icon fa-upload">REUPLOAD PHOTO </a>

                                        </li>
                                        <li>
                                            <a href="dropzone.php?value=delete&amp;image=<?php echo $_GET['nom'];?>&amp;country=<?php echo $donnees['country'];?>&amp;city=<?php echo $donnees['city'];?>" class="button small icon fa-trash">SUPPRIMER PHOTO</a>
                                        </li>
                                    </ul>


                    <form method="post" action="">
                    <div class="row uniform">
                            <div class="4u 12u$(xsmall)">
                                <input id="endroit" name="endroit" value="<?php echo str_replace('_', ' ', $donnees['endroit']);?>" placeholder="Endroit" type="text">
                            </div>
                            <div class="6u 12u$(xsmall)">
                                <textarea id="description" name="description" placeholder="Description" rows="1" style="" ><?php echo $donnees['description']; ?></textarea>
                            </div>
                        <ul class="actions">
                            <li>
                                <input class="special small icon fa-save" value="Sauvegarder modification" type="submit" style="">
                            </li>
                        </ul>
                    </div>

                    </form>
                    </p>


                <?php }} ?>



        </div>
</div>

<!-- Scripts -->
<script src="assets/JS/phantom/jquery.min.js"></script>
<script src="assets/JS/phantom/skel.min.js"></script>
<script src="assets/JS/phantom/util.js"></script>
<!--[if lte IE 8]><script src="assets/JS/phantom/ie/respond.min.js"></script><![endif]-->
<script src="assets/JS/phantom/main.js"></script>
<script src="assets/JS/dropzone/dropzone.js"></script>

</body>
</html>