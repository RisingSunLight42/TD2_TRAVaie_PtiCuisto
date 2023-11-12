<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
  <title>Nouvelle Recette</title>
    <script
            src="https://kit.fontawesome.com/908c130cac.js"
            crossorigin="anonymous"
        ></script>
    <title>Nouvelle Recette</title>
</head>
<body>
    <?php 
        require ("header.php");
    ?>
    <h1>Nouvelle recette</h1>
    <?php
    echo $content;
    ?>
    <form id="re_form" name="r_creation" method="post" action="index.php?action=recipeCreationHandling">
        <label for="re_title">Entrez le titre de la recette* :</label><input type="text" name="re_title" required/>
        <label for="re_desc">Entrez le contenu de votre recette* :</label><textarea name="re_desc" rows="10" required></textarea><br>
        <label for="re_resume">Entrez un résumé de votre recette* :</label><textarea name="re_resume" rows="5" required></textarea><br>
        <label for="re_img">Entrez un lien vers l'image de votre recette :</label><input type ="text" name="re_img"/>
        <label for="ingredient">Ajoutez vos ingrédients* :</label>
        <div class="autocomplete" style="width:300px;">
            <input id="ingredient" type="text" name="ingredient" placeholder="Ingrédient">
        </div>
        <br>
        <label for="re_cat">Quel est la catégorie de votre recette ?* </label>
        <input type="radio" name="re_cat" value="ENTREE"/>
        <label>Entrée</label>
        <input type="radio" name="re_cat" value="PLAT"/>
        <label>Plat</label>
        <input type="radio" name="re_cat" value="DESSERT"/>
        <label>Dessert</label>
        <input type="radio" name="re_cat" value="APERITIF"/>
        <label>Aperitif</label>
        <input type="radio" name="re_cat" value="BOISSON"/>
        <label>Boisson</label> <br/>
        <input type="submit" name="confirm" value="OK"/> 
        <input type="hidden" id="nbIngredients" name="nbIngredients" value="0"/>
    </form>

    
    <?php 
        require ("footer.php");
    ?>
    <script src="assets\js\autocompletion.js"></script>
    <script src="assets\js\allIngredients.js"></script>
</body>
</html>