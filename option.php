<!DOCTYPE HTML>
    <?php include('fcts_fichier.php'); include('fcts_bdd.php');include('const.inc.php');$bdd = BDD::appelBDD()?>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Phantom by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/JS/phantom/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/phantom/main.css" />
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
                <span class="symbol"><img src="pictures/phantom/logo.svg" alt="" /></span><span class="title">ACCUEIL</span>
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

    <!-- MainContent -->
    <div id="main">
        <div class="inner">
            <header>
                <h1>MENU</h1>
            </header>
            <section class="tiles">
            <?php
            $numeroImage = 1;
            $reponse = BDD::selectcountryBDD($bdd);
            foreach(option::Menu($reponse) as $element){;
            if($element['nom']!=='HOME'){?>

                    <article class="style<?php echo $numeroImage; ?>">
                        <span class="image">
                            <img src="pictures/phantom/pic0<?php echo $numeroImage; ?>.jpg" alt="" />
                        </span>
                        <a href="<?php echo $element['href']; ?>">
                            <h2><?php echo $element ['nom']; ?></h2>
                            <div class="content">
                                <p><?php echo $element['use']; ?></p>
                            </div>
                        </a>
                    </article>

           <?php $numeroImage = option::numeroImage($numeroImage); }}
            ;?>
            </section>
        </div>
    </div>


    <!-- Scripts -->
    <script src="assets/JS/phantom/jquery.min.js"></script>
    <script src="assets/JS/phantom/skel.min.js"></script>
    <script src="assets/JS/phantom/util.js"></script>
    <!--[if lte IE 8]><script src="assets/JS/phantom/ie/respond.min.js"></script><![endif]-->
    <script src="assets/JS/phantom/main.js"></script>

</body>
</html>