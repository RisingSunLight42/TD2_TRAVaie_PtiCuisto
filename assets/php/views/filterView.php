<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
    <script
            src="https://kit.fontawesome.com/908c130cac.js"
            crossorigin="anonymous"
        ></script>
    <title>Filtres</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
        require ("header.php");
    ?>
    <main>        <form method="post" action="index.php?action=filterRecipeName">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="reci_title" required>
            <input type="submit" value="Filtrer">
        </form>
        <form method="post" action="index.php?action=filterRecipeCategory">
            <label for="re_cat">Catégorie :</label><br>
            <input type="radio" name="re_cat" value="ENTREE"/>
            <label>Entrée</label><br>
            <input type="radio" name="re_cat" value="PLAT"/>
            <label>Plat</label><br>
            <input type="radio" name="re_cat" value="DESSERT"/>
            <label>Dessert</label><br>
            <input type="radio" name="re_cat" value="APERITIF"/>
            <label>Aperitif</label><br>
            <input type="radio" name="re_cat" value="BOISSON"/>
            <label>Boisson</label><br/>
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

    </main>
    <?php 
        require ("footer.php");
    ?>
    <script src="assets\js\autocompletion.js"></script>
    <script src="assets\js\allIngredients.js"></script>
</body>
</html>