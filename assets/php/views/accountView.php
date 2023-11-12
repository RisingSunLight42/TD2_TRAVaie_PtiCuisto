<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>PtiCuistot - Compte</title>
</head>
<body>
    <div id="menuButton">
        <a href="index.php">Accueil</a>
        <a href="index.php?action=allRecipes">Nos recettes</a>
        <a href="index.php?action=filter">Filtrer</a>
    </div>
    <div>
        <button><a href="index.php?action=recipeCreation">Creation</a></button>
        <?php
            echo $unlogButton
        ?>
    </div>
    <section>
        <?php
            echo $content;
        ?>
    </section>
</body>
</html>