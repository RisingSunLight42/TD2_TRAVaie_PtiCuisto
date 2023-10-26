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

        
        $nombre = 10;

        require_once("connexion.php");
        include_once("pdo_agile.php");

        

        $requete = "select reci_title, reci_resume, rtype_title, reci_image 
        from ptic_recipes 
        inner join ptic_recipes_type on ptic_recipes.rtype_id = ptic_recipes_type.rtype_id
        where reci_id <=".$nombre;

        LireDonneesPDO1($bdd,$requete, $tab);


        for ($i= 0; $i < count($tab); $i++){
            echo "<div>";
            echo '<img src='.$tab[$i]['reci_image'].'alt="image de recetee"/>';
            echo "<h1>".$tab[$i]['reci_title']."</h1>";
            echo "<h2>".$tab[$i]['rtype_title']."</h2>";
            echo "<p>".$tab[$i]['reci_resume']."<p>";
            echo "<div>";           
        }
        echo "<button>afficher plus</button>";
        ?>
</body>
</html>