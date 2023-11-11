<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
    <title>PtiCuistot - Connexion</title>
</head>
<body>
    <?php 
        require ("header.php");
    ?>
    <?php
    echo $content;
    ?>
    <h1 id="welcomeBackMessage">Content de vous revoir !</h1>
    <section id="formContent">
        <form id="connectionContent" action="index.php?action=connectionForm" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Votre email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
            <input type="submit" id="connectionButton" class="button" value="Connexion">
        </form>
    </section>
</body>
</html>