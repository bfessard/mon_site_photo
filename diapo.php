<?php
include('const.inc.php');
include ('fcts_bdd.php');

if (isset($_GET['variable'])) /*AND isset($_GET['id']))*/ {
    $bdd = BDD::appelBDD();
    $reponse = BDD::findpictures($bdd, $_GET['variable']);

    ?>


    <!DOCTYPE html>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="assets/css/slider/extra.slider.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/slider/diapo_css.css" rel="stylesheet" type="text/css"/>


    </head>
    <body>

    <div class="slider-wrapper">
        <div class="extra-slider">
            <?php

            while ($donnees = $reponse->fetch()) {

                echo '<div> <img src="pictures/' . $donnees['country'] . '/' . $donnees['city'] . '/' . $donnees['image'] . '" alt="" width="1000" height="700"></div> ';
            } ?>

        </div>
        <div class="navigation">
            <a href="#" class="prev">Previous</a>
            <a href="#" class="next">Next</a>
        </div>
        <div class="pagination"></div>
    </div>

    <script type="text/javascript" src="assets/JS/AJAX/libs/Jquery/3.3.1/JQuery.min.js"></script>
    <script type="text/javascript" src="assets/JS/AJAX/libs/gsap/1.18.5/TweenMax.min.js"></script>
    <script type="text/javascript" src="assets/JS/AJAX/libs/gsap/1.18.5/utils/Draggable.min.js"></script>
    <script type="text/javascript" src="assets/JS/AJAX/libs/gsap/1.18.5/plugins/ScrolltoPlugin.min.js"></script>
    <script type="text/javascript" src="assets/JS/sliders/js/simple.js"></script>
    <script type="text/javascript" src="assets/JS/extra.slider/js/extra.slider.js"></script>

    </body>

    </html>
    <?php
}
else
{
    echo '<meta http-equiv="refresh" content="1;url=index.php"/>';
}