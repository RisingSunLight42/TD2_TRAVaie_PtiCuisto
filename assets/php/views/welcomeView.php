<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
    <title>PtiCuistot - Accueil</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
        require ("header.php");
    ?>
    <main>
        <div>
            <img class="welcomePicture mt-3" src="./assets/images/recette/croque_monsieur.webp" alt="image de recette">
        </div>
        <section id="welcomeSection">
            <article id="lastRecipes">
                <h2 id="titleLastRecipes" >LES DERNIÈRES RECETTES</h2>
                <?php
                echo $content;
                ?>
            </article>
            <article id="edito">
                <img id="imgEdito" src="assets/images/Pticuisto.png" class="img-fluid rounded-start" alt="...">
                <h2 id="titleEdito">Edito</h2>
                
                <?php
                echo $edito;
                ?>
            </article>
        </section>
    </main>    
    <hr>
    <?php 
        require ("footer.php");
    ?>
</body>
</html>