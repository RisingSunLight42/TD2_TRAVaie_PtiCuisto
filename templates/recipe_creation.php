<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Recette</title>
</head>
<body>
    <p>Titre</p>
    <form id="re_form" name="r_creation" method="post" action="recipe_creation.php">
        Entrez le titre de la recette : <input type="text" name="re_title"/> <br/>
        Entrez le contenu de votre recette : <input type="text"  name="re_desc"/> <br/>
        
        Entrez un résumé de votre recette : <input type ="text" name="re_resume"/> <br/>
        Quel est la catégorie de votre recette ? 
        <input type="radio" name="re_cat" value="ENTREE"/>
        <input type="radio" name="re_cat" value="PLAT"/>
        <input type="radio" name="re_cat" value="DESSERT"/>
        <input type="radio" name="re_cat" value="APERITIF"/>
        <input type="radio" name="re_cat" value="BOISSON"/> <br/>
        <input type="submit" name="confirm" value="OK"/> 
    </form>
</body>
</html>