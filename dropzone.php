<!DOCTYPE html>
<?php
$ouverture=opendir(__DIR__ . '/pictures/import');
while (false !== ($fichier = readdir($repertoire)))
{
    $chemin = __DIR__ . '/pictures/import/'.$fichier; 
if($fichier != ".gitkeep")
{       unlink($chemin);
}
}
closedir($repertoire);
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

</body>

</html>
