<!DOCTYPE html>

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

<form action="afficher_photo.php" method="post">
    <p><input type="text" id="endroit"> </p>
    <p><textarea name="ameliorer" id="description"></textarea></p>
    <p><input type="submit" value="Envoyer" /></p>
</form>

</body>

</html>