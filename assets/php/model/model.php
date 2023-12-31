<?php
require_once("./assets/php/utils/connexion.php");
require_once("./assets/php/model/RecipesModel.php");
require_once("./assets/php/model/NeededIngredientsModel.php");
require_once("./assets/php/model/RecipesStashModel.php");
require_once("./assets/php/model/NeededIngredientsStashModel.php");
require_once("./assets/php/model/EditoModel.php");
require_once("./assets/php/model/IngredientsModel.php");
require_once("./assets/php/model/UsersModel.php");

/*The model is the treatment part of informations in the database. The controller will use the information to transfer them to the view. 
The treatment was mainly componsed of database's treatment, with selection for the displaying for websites's pages
and insertion for adding a new recipe or ingredient in the database*/ 

/*Recipe retrievment*/
function getRecipes($number) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipes($number);
}

function getRecipesByTitle($title) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipesByTitle($title);
}

function getRecipesByCategory($category) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipesByCategory($category);
}

function getRecipesByIngredients($ingredients) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipesByIngredients($ingredients);
}

/*Get the number total of recipe*/
function getRecipesCount() {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipesCount();
}

/*Retrive one recipe with its id */
function getRecipeById($reci_id) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getRecipeById($reci_id);
}

function getRecipeStashById($reci_id) {
    $recipesStashModel = new RecipesStashModel(false);
    return $recipesStashModel->getRecipeStashById($reci_id);
}

/*Retrieve the ingredients of one recipe*/
function getRecipeIngredients($reci_id) {
    $neededIngredientsModel = new NeededIngredientsModel(false);
    return $neededIngredientsModel->getRecipeIngredients($reci_id);
}

/*Retrieve the ingredients of one recipe*/
function getRecipeStashIngredients($reci_id) {
    $neededIngredientsStashModel = new NeededIngredientsStashModel(false);
    return $neededIngredientsStashModel->getRecipeStashIngredients($reci_id);
}

/*Retrieve the three last recipes published ont the website*/
function getLastNRecipes($number) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getLastNRecipes($number);
}

/*Retrieve the last Edito published*/
function getLastEdito() {
    $editoModel = new EditoModel(false);
    return $editoModel->getLastEdito();
}

function getIngredients() {
    $ingredientsModel = new IngredientsModel(false);
    return $ingredientsModel->getIngredients();
}

function createRecipe($title, $desc, $resume, $categorize, $img, $user, $isAdmin) {
    $recipesModel = new RecipesModel($isAdmin);
    return $recipesModel->createRecipe($title, $desc, $resume, $categorize, $img, $user);
}

function addRecipesIngredients($reci_id, $ingredients, $isAdmin) {
    $neededIngredientsModel = new NeededIngredientsModel($isAdmin);
    $neededIngredientsModel->addRecipesIngredients($reci_id, $ingredients);
}

function editRecipe($reci_id, $title, $desc, $resume, $category, $img, $user, $isAdmin) {
    $recipesModel = new RecipesModel($isAdmin);
    return $recipesModel->editRecipe($reci_id, $title, $desc, $resume, $category, $img, $user);
}

function editRecipesIngredients($reci_id, $ingredients, $isAdmin) {
    $neededIngredientsModel = new NeededIngredientsModel($isAdmin);
    $neededIngredientsModel->editRecipesIngredients($reci_id, $ingredients);
}

/* To delete a recipe */
function deleteRecipe($reci_id) {
    $recipesModel = new RecipesModel(false);
    $recipesModel->deleteRecipe($reci_id);
}

/* To delete a recipe */
function deleteStashRecipe($reci_stash_id) {
    $recipesStashModel = new RecipesStashModel(false);
    $recipesStashModel->deleteStashRecipe($reci_stash_id);
}

function getConnectionCredentials($username) {
    $usersModel = new UsersModel(false);
    return $usersModel->getConnectionCredentials($username);
}

function addEdito($edito) {
    $editoModel = new EditoModel(false);
    $editoModel->addEdito($edito);
}

function getWaitingForCreationRecipes(){
    $recipesStashModel = new RecipesStashModel(false);
    return $recipesStashModel->getWaitingForCreationRecipes();
}

function getWaitingForModificationRecipes(){
    $recipesStashModel = new RecipesStashModel(false);
    return $recipesStashModel->getWaitingForModificationRecipes();
}
?>