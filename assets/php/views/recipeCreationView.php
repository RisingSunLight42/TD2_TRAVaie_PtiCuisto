<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Recette</title>
</head>
<body>
    <h1>Nouvelle recette</h1>
    <form id="re_form" name="r_creation" method="post" action="index.php?action=recipeCreationHandling">
        Entrez le titre de la recette : <input type="text" name="re_title"/> <br/>
        Entrez le contenu de votre recette : <input type="text"  name="re_desc"/> <br/>
        Entrez un résumé de votre recette : <input type ="text" name="re_resume"/> <br/>
        Quel est la catégorie de votre recette ? 
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
    </form>
</body>
</html>