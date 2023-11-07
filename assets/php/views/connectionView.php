<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PtiCuistot - Connexion</title>
</head>
<body>
    <div id="menuButton">
        <a href="index.php?action=welcome">Accueil</a>
        <a href="index.php?action=allRecipes">Nos recettes</a>
        <a href="index.php?action=filter">Filtrer</a>
    </div>
    <?php
    echo $content;
    ?>
    <form action="index.php?action=connectionForm" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" placeholder="Jean-Marc666" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="******" required>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>