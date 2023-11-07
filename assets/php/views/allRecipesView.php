<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos recettes</title>
</head>
<body>
    

    <div id="menuButton">
        <a href="index.php?action=welcome">Accueil</a>
        <a href ="index.php?action=recipe">Recette simple</a>
    <div>
        <?php
            echo $content;
            if ($number > 20) {
                $anchor = $number - 20;
                echo "<script type='text/javascript'>",
                    "window.location.href = '#$anchor';",
                    "</script>";
            }
        ?>
</body>
</html>