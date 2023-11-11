<?php
require('./assets/php/controllers/controller.php');   

if (isset($_GET['action'])) {
    $action = strip_tags($_GET['action']);
    if ($action == 'welcome') welcome();
    elseif ($action == 'allRecipes') getAllRecipes();
    elseif ($action == 'recipeCreation') recipeCreation();
    elseif ($action == 'recipeCreationHandling') recipeCreationHandling();
    elseif ($action == 'recipeEdition') recipeEdition();
    elseif ($action == 'recipeEditionHandling') recipeEditionHandling();
    elseif ($action == 'recipeDeletion') recipeDeletion();
    elseif ($action == 'filter') filter();
    elseif ($action == 'recipe') recipe();
    elseif ($action == 'account') account();
    elseif ($action == 'connectionForm') connectionForm();
    elseif ($action == 'getAllIngredients') getAllIngredients();
    elseif ($action == 'disconnect') disconnect();
    else welcome();
}
else {
    welcome();
}
?>