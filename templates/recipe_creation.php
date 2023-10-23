<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Recette</title>
</head>
<body>
    <h1>Nouvelle recette</h1>
    <form id="re_form" name="r_creation" method="post" action="form_creation_recipe_treatment.php">
        Entrez le titre de la recette : <input type="text" name="re_title"/> <br/>
        Entrez le contenu de votre recette : <input type="text"  name="re_desc"/> <br/>
        
        Entrez un résumé de votre recette : <input type ="text" name="re_resume"/> <br/>
        Quel est la catégorie de votre recette ? 
        <label>ENTREE</label>
        <input type="radio" name="re_cat" value="1"/>
        <label>ENTREE</label>
        <input type="radio" name="re_cat" value="2"/>
        <label>PLAT</label>
        <input type="radio" name="re_cat" value="3"/>
        <label>DESSERT</label>
        <input type="radio" name="re_cat" value="4"/>
        <label>APERITIF</label>
        <input type="radio" name="re_cat" value="5"/>
        <label>BOISSON</label> <br/>
        <input type="submit" name="confirm" value="OK"/> 
    </form>
</body>
</html>