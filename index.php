<?php
require('./assets/php/controllers/controller.php');   

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'accueil') accueil();
    elseif ($action == 'allRecipes') getAllRecipes();
    elseif ($action == 'recipeCreation') recipeCreation();
    elseif ($action == 'recipeCreationHandling') recipeCreationHandling();
    elseif ($action == 'recipeModification') recipeModification();
    elseif ($action == 'recipeDeletion') recipeDeletion();
    elseif ($action == 'filter') filter();
    elseif ($action == 'recipe') recipe();
    elseif ($action == 'account') account();
    else accueil();
}
else {
    accueil();
}
?>