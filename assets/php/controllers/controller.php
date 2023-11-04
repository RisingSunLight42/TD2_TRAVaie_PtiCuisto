<?php
require('./assets/php/model/model.php');

function getAllRecipes() {
    [$recipes, $number, $count] = getRecipes();
    $content = "";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        $recipe_id = $recipe['reci_id'];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $type = $recipe['rtype_title'];
        $image = $recipe['reci_image'];
        $anchor = $i + 1;
        $content .= "<div id='$anchor'>";
        $content .= "<img src='$image' alt='image de recette' onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" width=50px height=50px/>" ;
        $content .= "<h1 onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" >$title</h1>";
        $content .= "<h2>$type</h2>";
        $content .= "<p>$resume<p>";
        $content .= "</div>";           
    }
    if ($count > $number) {
        $number += 10;
        $content .= "<form action='' method='post'><input type='hidden' id='number' name='number' value='$number' /><input type='submit' value='Afficher plus' /></form>";
    }
    require('./assets/php/views/allRecipesView.php');
}

function accueil() {
    require('./assets/php/views/accueilView.php');
}

function recipe() {
    $reci_id = $_GET['value'];
    $recipe = getOneRecipe($reci_id);
    $ingredients = getRecipeIngredients($reci_id);

    // Ingredients building format
    $ingredientsHTML = "";
    if (!is_null($ingredients)) {
        $ingredientsHTML = "<h2>Ingrédients nécessaires</h2><p>";
    $nbIngredients = count($ingredients);
    for ($i= 0; $i < $nbIngredients - 1; $i++){
        $ingredientsHTML .= $ingredients[$i]['ing_title'].", ";
    }
    $ingredientsHTML .= $ingredients[$nbIngredients - 1]['ing_title'].".";
    $ingredientsHTML .= "</p>";
    }

    // Recipe building format
    $title = $recipe['reci_title'];
    $type = $recipe['rtype_title'];
    $reci_content = $recipe['reci_content'];
    $reci_content = str_replace("\n", "<br>", $reci_content);
    $image = $recipe['reci_image'];
    $creationDate = $recipe['reci_creation_date'];
    $lastUpdateDate = $recipe['reci_edit_date'];
    $editorUsername = $recipe['users_nickname'];
    $content = "<h1>$title</h1>";
    $content .= "<p>$type</p>";
    $content .= $ingredientsHTML;
    $content .= "<h2>Recette</h2><p>$reci_content</p>";
    $content .= "<p>Créé le : $creationDate par $editorUsername</p>";
    $content .= "<p>Édité pour la dernière fois le : $lastUpdateDate</p>";
    $content .= "<img src='$image' alt='image de recette' width=200px height=200px/>" ;
    require('./assets/php/views/recipeView.php');
}

function filter() {
    require('./assets/php/views/filterView.php');
}

function account() {
    require('./assets/php/views/accountView.php');
}

function recipeCreation() {
    require('./assets/php/views/recipeCreationView.php');
}

function recipeCreationHandling() {
    require('./assets/php/views/recipeCreationHandlingView.php');
}

function recipeModification() {
    require('./assets/php/views/recipeModificationView.php');
}

function recipeDeletion() {
    require('./assets/php/views/recipeDeletionView.php');
}
?>