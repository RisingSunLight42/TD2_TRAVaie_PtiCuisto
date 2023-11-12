<?php
require_once("./assets/php/utils/connexion.php");
include_once("./assets/php/utils/pdo_agile.php");
/*The model is the treatment part of informations in the database. The controller will use the information to transfer them to the view. 
The treatment was mainly componsed of database's treatment, with selection for the displaying for websites's pages
and insertion for adding a new recipe or ingredient in the database*/ 

/*Recipe retrievment*/
function getRecipes($number) {
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image, users_nickname
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    ORDER BY reci_id LIMIT :limit";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->bindValue(':limit', (int) $number, PDO::PARAM_INT);
    $preparedRecipesGet->execute();

    return $preparedRecipesGet->fetchAll();
}


function getRecipesByTitle($title) {
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    WHERE reci_title LIKE UPPER(?)
    ORDER BY reci_id";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->execute(['%'.$title.'%']);

    return $preparedRecipesGet->fetchAll();
}

function getRecipesByCategory($category) {
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    WHERE rtype_title LIKE UPPER(?)
    ORDER BY reci_id";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->execute(['%'.$category.'%']);

    return $preparedRecipesGet->fetchAll();
}

function getRecipesByIngredients($ingredients) {
    $bdd = dbConnect();
    
    $recipeRequest = "SELECT DISTINCT reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_needed_ingredients USING (reci_id)
    JOIN ptic_ingredients USING (ing_id)
    WHERE ing_title = UPPER(:ingredient0)";

    for ($i=1; $i<count($ingredients); $i++) {
        $recipeRequest .= "OR ing_title= UPPER(:ingredient$i)";
    }
    $preparedRecipesGet = $bdd->prepare($recipeRequest);
    for ($j=0; $j<count($ingredients); $j++) {
        $preparedRecipesGet->bindValue(":ingredient$j", (string) $ingredients[$j], PDO::PARAM_STR);
    }
    $preparedRecipesGet->execute();

    return $preparedRecipesGet->fetchAll();
}

/*Get the number total of recipe*/
function getRecipesCount() {
    $bdd = dbConnect();
    $countRequest = "SELECT COUNT(*) as count FROM ptic_recipes";
    LireDonneesPDO1($bdd, $countRequest, $count);
    return $count[0]['count'];
}

/*Retrive one recipe with its id */
function getOneRecipe($reci_id) {
    $bdd = dbConnect();

    $preparedRecipeRequest = "SELECT reci_title, rtype_title, reci_image, reci_content, users_nickname, reci_resume,
    DATE_FORMAT(reci_creation_date, '%d/%m/%Y') as reci_creation_date, DATE_FORMAT(reci_edit_date, '%d/%m/%Y') as reci_edit_date
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    WHERE reci_id = ?";
    $preparedRequestGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRequestGet->execute([$reci_id]);
    return $preparedRequestGet->fetchAll();
}

function getOneRecipeStash($reci_id) {
    $bdd = dbConnect();

    $preparedRecipeRequest = "SELECT reci_stash_title as reci_title, rtype_title, reci_stash_image as reci_image, reci_stash_content as reci_content, stash_type_value,
    users_nickname, reci_stash_resume as reci_resume, DATE_FORMAT(reci_stash_creation_date, '%d/%m/%Y') as reci_creation_date, DATE_FORMAT(reci_stash_creation_date, '%d/%m/%Y') as reci_edit_date, reci_id
    FROM ptic_recipes_stash
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    JOIN ptic_stash_type USING (stash_type_id)
    WHERE reci_stash_id = ?";
    $preparedRequestGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRequestGet->execute([$reci_id]);
    return $preparedRequestGet->fetchAll();
}

/*Retrieve the ingredients of one recipe*/
function getRecipeIngredients($reci_id) {
    $bdd = dbConnect();

    $preparedIngredientsRequest = "SELECT ing_title
    FROM ptic_needed_ingredients
    JOIN ptic_ingredients USING (ing_id)
    WHERE reci_id = ?";
    $preparedRequestGet = $bdd->prepare($preparedIngredientsRequest);
    $preparedRequestGet->execute([$reci_id]);
    return $preparedRequestGet->fetchAll();
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
function getLastThreeRecipes() {
    $bdd = dbConnect();
    
    $recipeRequest = "SELECT reci_id, reci_title, reci_resume, reci_image
    FROM ptic_recipes
    ORDER BY reci_creation_date DESC LIMIT 3";
    LireDonneesPDO1($bdd, $recipeRequest, $recipes);
    return $recipes;
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
    $bdd = dbConnect();
    $sql = "";
    if ($isAdmin) {
        $sql= "INSERT INTO ptic_recipes(reci_title, reci_content, reci_resume, rtype_id, reci_creation_date, reci_edit_date, reci_image, users_id)
        VALUES (:title, :descr, :resume,(
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), sysdate(), sysdate(), :img, (
            SELECT users_id
            FROM ptic_users
            WHERE users_nickname = :user
        ))";
    } else {
        $sql= "INSERT INTO ptic_recipes_stash(reci_stash_title, reci_stash_content, reci_stash_resume,
        rtype_id, reci_stash_creation_date, reci_stash_image, users_id, stash_type_id)
        VALUES (:title, :descr, :resume,(
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), sysdate(), :img, (
            SELECT users_id
            FROM ptic_users
            WHERE users_nickname = :user
        ), (SELECT stash_type_id FROM ptic_stash_type WHERE UPPER(stash_type_value) = 'CREATION'))";
    }
    $preparedCreateRecipe = $bdd->prepare($sql);
    $preparedCreateRecipe->bindValue(':title', (string) $title, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':descr', (string) $desc, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':resume', (string) $resume, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':cat', (string) $categorize, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':img', (string) $img, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':user', (string) $user, PDO::PARAM_STR);
    $preparedCreateRecipe->execute();
    return $bdd->lastInsertId();
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
        ), reci_edit_date = sysdate(), reci_image = :img
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
        ), sysdate(), :img, (
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

    $editoRequest = "INSERT INTO ptic_edito (edi_text, edi_date) VALUES (?, sysdate())";
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