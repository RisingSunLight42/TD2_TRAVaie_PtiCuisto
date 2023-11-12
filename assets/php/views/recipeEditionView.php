<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("head.php")?>
    <title>Modification de recette</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require("header.php")?>
    <main>
        <h1>Modification de recette</h1>
        <?php
        echo $content;
        ?>
        <form id="re_form" name="r_creation" method="post" action="index.php?action=recipeEditionHandling&value=<?php echo $reci_id; ?>">
            <label for="re_title">Entrez le titre de la recette* :</label><input type="text" name="re_title" value=<?php echo '"'.$title.'"'; ?> required/>
            <label for="re_desc">Entrez le contenu de votre recette* :</label><textarea name="re_desc" rows="10" required><?php echo $description; ?></textarea><br>
            <label for="re_resume">Entrez un résumé de votre recette* :</label><textarea name="re_resume" rows="5" required><?php echo $resume; ?></textarea><br>
            <label for="re_img">Entrez un lien vers l'image de votre recette :</label><input type ="text" name="re_img" value=<?php echo $img; ?> />
            <label for="ingredient">Ajoutez vos ingrédients* :</label>
            <?php echo $ingredients; ?>
            <div class="autocomplete" style="width:300px;">
                <input id="ingredient" type="text" name="ingredient" placeholder="Ingrédient">
            </div>
            <br>
            <label for="re_cat">Quel est la catégorie de votre recette ?* </label>
            <input type="radio" name="re_cat" value="ENTREE" <?php echo $entry; ?> />
            <label>Entrée</label>
            <input type="radio" name="re_cat" value="PLAT" <?php echo $dish; ?>/>
            <label>Plat</label>
            <input type="radio" name="re_cat" value="DESSERT" <?php echo $dessert; ?>/>
            <label>Dessert</label>
            <input type="radio" name="re_cat" value="APERITIF" <?php echo $aperitif; ?>/>
            <label>Aperitif</label>
            <input type="radio" name="re_cat" value="BOISSON" <?php echo $drink; ?>/>
            <label>Boisson</label> <br/>
            <input type="submit" name="confirm" value="OK"/> 
            <input type="hidden" id="nbIngredients" name="nbIngredients" value=<?php echo $nbIngredients ?>>
        </form>
    </main>
    <?php require("footer.php")?>
    <script src="assets\js\autocompletion.js"></script>
    <script src="assets\js\allIngredients.js"></script>
</body>
</html>