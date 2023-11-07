<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PtiCuistot - Accueil</title>
</head>
<body>
    <div id="menuButton">
        <a href="index.php?action=welcome">Accueil</a>
        <a href="index.php?action=allRecipes">Nos recettes</a>
        <a href="index.php?action=filter">Filtrer</a>
        <a href="index.php?action=account">Connexion</a>
    </div>
    <?php
        echo $content;
    ?>
</body>
</html>