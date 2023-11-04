<?php
require('./assets/php/model/model.php');

function getAllRecipes() {
    $recipes = getRecipes();
    $content = "";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $type = $recipe['rtype_title'];
        $image = $recipe['reci_image'];
        $content .= "<div>";
        $content .= "<img src='$image' alt='image de recette' width=50px height=50px/>" ;
        $content .= "<h1>$title</h1>";
        $content .= "<h2>$type</h2>";
        $content .= "<p>$resume<p>";
        $content .= "</div>";           
    }
    $content .= "<button>Afficher plus</button>";

    require('./assets/php/views/allRecipesView.php');
}

function accueil() {
    require('./assets/php/views/accueilView.php');
}

function recipe() {
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