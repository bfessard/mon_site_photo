<!DOCTYPE html>
<?php
include('fcts_fichier.php');
include('fcts_bdd.php');
?>
<head>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
    <link href="CSS/dropzone/dropzone.css" type="text/css" rel="stylesheet" />

    <!-- 2 -->
    <script src="JS/dropzone/dropzone.js"></script>

</head>

<body>

<!-- 3 -->
<form action="upload.php" class="dropzone"></form>

<form method="post" action="afficher_photo.php" >
    <p>
        <label>Endroit</label> : <input type="text" name="endroit" id="endroit"></br>
        <label>Description</label> : <textarea name="description" id="description" rows ="10" cols="50"></textarea> </br>
        <input type="submit" value="Envoyer" />
    </p>
</form>
<p>nombre de photos dans import : <?php  echo photo::compteur() ;?> </p> <form><input type="button" value="supprimer" onclick="<?php photo::delete(); ?>"></form>

</html>

