<?php
require('./assets/php/model/model.php');

function getAllRecipes() {
    $recipes = getRecipes();
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