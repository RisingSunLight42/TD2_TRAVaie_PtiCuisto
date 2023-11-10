<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Nouvelle Recette</title>
</head>
<body>
    <h1>Nouvelle recette</h1>

    <form id="re_form" name="r_creation" method="post" action="index.php?action=recipeCreationHandling">
        <label for="re_title">Entrez le titre de la recette :</label><input type="text" name="re_title"/>
        <label for="re_desc">Entrez le contenu de votre recette :</label><input type="text"  name="re_desc"/>
        <label for="re_resume">Entrez un résumé de votre recette :</label><input type ="text" name="re_resume"/>
        <label for="ingredient">Ajoutez vos ingrédients :</label>
        <div class="autocomplete" style="width:300px;">
            <input id="ingredient1" type="text" name="ingredient" placeholder="Ingrédient">
        </div>
        <br>
        <label for="re_cat">Quel est la catégorie de votre recette ? </label>
        <input type="radio" name="re_cat" value="ENTREE"/>
        <label>Entrée</label>
        <input type="radio" name="re_cat" value="PLAT"/>
        <label>Plat</label>
        <input type="radio" name="re_cat" value="DESSERT"/>
        <label>DESSERT</label>
        <input type="radio" name="re_cat" value="APERITIF"/>
        <label>APERITIF</label>
        <input type="radio" name="re_cat" value="BOISSON"/>
        <label>BOISSON</label> <br/>
        <input type="submit" name="confirm" value="OK"/> 
        <input type="hidden" id="nbIngredients" name="nbIngredients" value="0"/>
    </form>

    <script src="assets\js\autocompletion.js"></script>
    <script src="assets\js\allIngredients.js"></script>
</body>
</html>