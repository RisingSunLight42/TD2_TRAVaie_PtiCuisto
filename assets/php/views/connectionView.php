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
    <form action="index.php?action=connectionForm" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="jeanmarc666@gmail.com" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="******" required>
        <input type="submit" value="Connexion">
    </form>
    <?php 
        require ("footer.php");
    ?>
</body>
</html>