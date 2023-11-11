<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script
            src="https://kit.fontawesome.com/908c130cac.js"
            crossorigin="anonymous"
        ></script>
    <title>Filtres</title>
</head>
<body>
    <div id="menuButton">
        <a href="index.php">Accueil</a>
    </div>
    <form method="post" action="index.php?action=filterRecipeName">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="reci_title" required>
        <input type="submit" value="Filtrer">
    </form>
    <form method="post" action="index.php?action=filterRecipeCategory">
        <label for="re_cat">Catégorie :</label>
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
        <input type="submit" value="Filtrer">
    </form>
    <form method="post" action="index.php?action=filterRecipeIngredients">
        <label for="ingredient">Ingrédients :</label>
        <div class="autocomplete" style="width:300px;">
            <input id="ingredient" type="text" name="ingredient" placeholder="Ingrédient">
        </div>
        <input type="hidden" id="nbIngredients" name="nbIngredients" value="0"/>
        <input type="submit" value="Filtrer">
    </form>
    <section>
        <?php
            echo $content;
        ?>
    </section>
    <script src="assets\js\autocompletion.js"></script>
    <script src="assets\js\allIngredients.js"></script>
</body>
</html>