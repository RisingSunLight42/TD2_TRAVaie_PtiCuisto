<?php
require_once("./assets/php/utils/connexion.php");
require_once("./assets/php/model/RecipesModel.php");
require_once("./assets/php/model/NeededIngredients.php");
require_once("./assets/php/model/RecipesStashModel.php");
require_once("./assets/php/model/NeededIngredientsStash.php");
include_once("./assets/php/utils/pdo_agile.php");
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
    $neededIngredientsModel = new NeededIngredients(false);
    return $neededIngredientsModel->getRecipeIngredients($reci_id);
}

/*Retrieve the ingredients of one recipe*/
function getRecipeStashIngredients($reci_id) {
    $bdd = dbConnect();

    $preparedIngredientsRequest = "SELECT ing_title
    FROM ptic_needed_ingredients_stash
    JOIN ptic_ingredients USING (ing_id)
    WHERE reci_stash_id = ?";
    $preparedRequestGet = $bdd->prepare($preparedIngredientsRequest);
    $preparedRequestGet->execute([$reci_id]);
    return $preparedRequestGet->fetchAll();
}

/*Retrieve the three last recipes published ont the website*/
function getLastNRecipes($number) {
    $recipesModel = new RecipesModel(false);
    return $recipesModel->getLastNRecipes($number);
}

/*Retrieve the last Edito published*/
function getLastEdito() {
    $bdd = dbConnect();
    
    $editoRequest = "SELECT edi_text
    FROM ptic_edito
    ORDER BY edi_date DESC LIMIT 1";
    LireDonneesPDO1($bdd, $editoRequest, $edito);
    return $edito[0]['edi_text'];
}

function getIngredients() {
    $bdd = dbConnect();
    
    $ingredientsRequest = "SELECT ing_id, ing_title
    FROM ptic_ingredients";
    LireDonneesPDO1($bdd, $ingredientsRequest, $ingredients);
    return $ingredients;
}

function createRecipe($title, $desc, $resume, $categorize, $img, $user, $isAdmin) {
    $recipesModel = new RecipesModel($isAdmin);
    return $recipesModel->createRecipe($title, $desc, $resume, $categorize, $img, $user);
}

function addRecipesIngredients($reci_id, $ingredients, $isAdmin) {
    $bdd = dbConnect();
    $neededIngredient = "";
    if ($isAdmin) {
        $neededIngredient = "INSERT INTO ptic_needed_ingredients (reci_id, ing_id) VALUES (?, (
            SELECT ing_id
            FROM ptic_ingredients
            WHERE TRIM(UPPER(ing_title)) = TRIM(UPPER(?))
            )
        )";
    } else {
        $neededIngredient = "INSERT INTO ptic_needed_ingredients_stash (reci_stash_id, ing_id) VALUES (?, (
            SELECT ing_id
            FROM ptic_ingredients
            WHERE TRIM(UPPER(ing_title)) = TRIM(UPPER(?))
            )
        )";
    }
    $preparedNeededIngredient = $bdd->prepare($neededIngredient);
    for ($i= 0; $i < count($ingredients); $i++) {
        $preparedNeededIngredient->execute([$reci_id, $ingredients[$i]]);
    }
}
function editRecipe($reci_id, $title, $desc, $resume, $categorize, $img, $user, $isAdmin) {
    $bdd = dbConnect();
    $sql = "";
    if ($isAdmin) {
        $sql= "UPDATE ptic_recipes
        SET reci_title = :title, reci_content = :descr, reci_resume = :resume, rtype_id = (
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), reci_edit_date = NOW(), reci_image = :img
        WHERE users_id = (
            SELECT users_id
            FROM ptic_users
            WHERE users_nickname = :user
        ) AND reci_id = :reci_id";
    } else {
        $sql= "INSERT INTO ptic_recipes_stash(reci_stash_title, reci_stash_content, reci_stash_resume,
        rtype_id, reci_stash_creation_date, reci_stash_image, users_id, stash_type_id, reci_id)
        VALUES (:title, :descr, :resume,(
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), NOW(), :img, (
            SELECT users_id
            FROM ptic_users
            WHERE users_nickname = :user
        ), (SELECT stash_type_id FROM ptic_stash_type WHERE UPPER(stash_type_value) = 'MODIFICATION'), $reci_id)";
    }
    
    $preparedCreateRecipe = $bdd->prepare($sql);
    $preparedCreateRecipe->bindValue(':title', (string) $title, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':descr', (string) $desc, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':resume', (string) $resume, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':cat', (string) $categorize, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':img', (string) $img, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':user', (string) $user, PDO::PARAM_STR);
    if ($isAdmin)$preparedCreateRecipe->bindValue(':reci_id', (int) $reci_id, PDO::PARAM_INT);
    $preparedCreateRecipe->execute();
    return $bdd->lastInsertId();
}

function editRecipesIngredients($reci_id, $ingredients, $isAdmin) {
    $bdd = dbConnect();
    if ($isAdmin) {
        $deleteRecipeIngredientsSQL = "DELETE FROM ptic_needed_ingredients WHERE reci_id = ?";
        $prepareDeleteRecipeIngredients = $bdd->prepare($deleteRecipeIngredientsSQL);
        $prepareDeleteRecipeIngredients->execute([$reci_id]);
    }

    addRecipesIngredients($reci_id, $ingredients, $isAdmin);
}

/* To delete a recipe */
function deleteRecipe($reci_id) {
    $bdd = dbConnect();

    $deleteRecipeIngredientsSQL = "DELETE FROM ptic_needed_ingredients WHERE reci_id = ?";
    $deleteRecipeSQL = "DELETE FROM ptic_recipes WHERE reci_id = ?";

    $prepareDeleteRecipeIngredients = $bdd->prepare($deleteRecipeIngredientsSQL);
    $prepareDeleteRecipe = $bdd->prepare($deleteRecipeSQL);

    $prepareDeleteRecipeIngredients->execute([$reci_id]);
    $prepareDeleteRecipe->execute([$reci_id]);
}

/* To delete a recipe */
function deleteRecipeStash($reci_stash_id) {
    $bdd = dbConnect();

    $deleteRecipeIngredientsSQL = "DELETE FROM ptic_needed_ingredients_stash WHERE reci_stash_id = ?";
    $deleteRecipeSQL = "DELETE FROM ptic_recipes_stash WHERE reci_stash_id = ?";

    $prepareDeleteRecipeIngredients = $bdd->prepare($deleteRecipeIngredientsSQL);
    $prepareDeleteRecipe = $bdd->prepare($deleteRecipeSQL);

    $prepareDeleteRecipeIngredients->execute([$reci_stash_id]);
    $prepareDeleteRecipe->execute([$reci_stash_id]);
}

function getConnectionCredentials($username) {
    $bdd = dbConnect();

    $getCredentialsRequest = "SELECT users_nickname, users_password, utype_title FROM ptic_users JOIN ptic_users_type USING (utype_id) WHERE users_nickname = ?";
    $preparedRequestGet = $bdd->prepare($getCredentialsRequest);
    $preparedRequestGet->execute([$username]);
    return $preparedRequestGet->fetchAll();
}

function addEdito($edito) {
    $bdd = dbConnect();

    $editoRequest = "INSERT INTO ptic_edito (edi_text, edi_date) VALUES (?, NOW())";
    $editoRequestPrepared = $bdd->prepare($editoRequest);
    $editoRequestPrepared->execute([$edito]);
}

function getWaitingForCreationRecipes(){
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_stash_id as reci_id, reci_stash_title as reci_title, reci_stash_resume as reci_resume, rtype_title,
    reci_stash_image as reci_image, users_nickname
    FROM ptic_recipes_stash
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    WHERE stash_type_id = (SELECT stash_type_id FROM ptic_stash_type WHERE UPPER(stash_type_value) = 'CREATION')";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->execute();

    return $preparedRecipesGet->fetchAll();
}

function getWaitingForModificationRecipes(){
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_stash_id as reci_id, reci_stash_title as reci_title, reci_stash_resume as reci_resume, rtype_title,
    reci_stash_image as reci_image, users_nickname
    FROM ptic_recipes_stash
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    WHERE stash_type_id = (SELECT stash_type_id FROM ptic_stash_type WHERE UPPER(stash_type_value) = 'MODIFICATION')";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->execute();

    return $preparedRecipesGet->fetchAll();
}
?>