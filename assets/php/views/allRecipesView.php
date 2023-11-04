<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos recettes</title>
</head>
<body>
    

    <div id="menuButton">
        <a href="index.php?action=accueil">Accueil</a>
        <a href ="index.php?action=recipe">Recette simple</a>
    <div>
        <?php
            for ($i= 0; $i < count($recipes); $i++){
                echo "<div>";
                echo '<img src='.$recipes[$i]['reci_image'].'alt="image de recetee"/>';
                echo "<h1>".$recipes[$i]['reci_title']."</h1>";
                echo "<h2>".$recipes[$i]['rtype_title']."</h2>";
                echo "<p>".$recipes[$i]['reci_resume']."<p>";
                echo "<div>";           
            }
            echo "<button>afficher plus</button>";
        ?>
</body>
</html>