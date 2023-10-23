<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Recette</title>
</head>
<body>
    <p>Titre</p>
    <form name="r_creation" method="post" action="recipe_creation.php">
        Entrez le titre de la recette : <input type="text" name="re_title"/> 
        Entrez le contenu de votre recette : <input type="text"  name="re_desc"/>
        
        

        <input type="submit" name="confirm" value="OK"/>
    </form>
</body>
</html>