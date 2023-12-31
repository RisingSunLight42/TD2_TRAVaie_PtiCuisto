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
    elseif ($action == 'editoEdition') editoEdition();
    elseif (substr( $action, 0, 6) === 'filter') filter();
    elseif ($action == 'recipe') recipe();
    elseif ($action == 'recipeStash') recipeStash();
    elseif ($action == 'account') account();
    elseif ($action == 'connectionForm') connectionForm();
    elseif ($action == 'getAllIngredients') getAllIngredients();
    elseif ($action == 'disconnect') disconnect();
    elseif ($action == 'refuse') refuse();
    elseif ($action == 'validate') validate();
    else welcome();
}
else {
    welcome();
}
?>
