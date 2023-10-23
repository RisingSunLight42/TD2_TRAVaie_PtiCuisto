<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos recettes</title>
</head>
<body>
    <div id="menuButton">
        <a href="../index.php">Accueil</a>
        <a href ="./recipe.php">Recette simple</a>
    <div>
        <?php
        require_once("connexion.php");
        include_once("pdo_agile.php");

        $requete = "select * from ptic_recipes";

        LireDonneesPDO1($bdd,$requete, $tab);
        for ($i= 0; $i < count($tab); $i++){
            echo "<div>";
            echo "<h1>".$tab[$i]['reci_title']."</h1>";
        }
        ?>
</body>
</html>