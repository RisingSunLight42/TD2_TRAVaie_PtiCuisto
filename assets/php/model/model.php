<?php
require_once("./assets/php/utils/connexion.php");
include_once("./assets/php/utils/pdo_agile.php");

function getRecipes($number) {
    $bdd = dbConnect();
    
    $preparedRecipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    ORDER BY reci_id LIMIT :limit";

    $preparedRecipesGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRecipesGet->bindValue(':limit', (int) $number, PDO::PARAM_INT);
    $preparedRecipesGet->execute();

    return $preparedRecipesGet->fetchAll();
}

function getRecipesCount() {
    $bdd = dbConnect();
    $countRequest = "SELECT COUNT(*) as count FROM ptic_recipes";
    LireDonneesPDO1($bdd, $countRequest, $count);
    return $count[0]['count'];
}

function getOneRecipe($reci_id) {
    $bdd = dbConnect();

    $preparedRecipeRequest = "SELECT reci_title, rtype_title, reci_image, reci_content, users_nickname,
    DATE_FORMAT(reci_creation_date, '%d/%m/%Y') as reci_creation_date, DATE_FORMAT(reci_edit_date, '%d/%m/%Y') as reci_edit_date
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    JOIN ptic_users USING (users_id)
    WHERE reci_id = ?";
    $preparedRequestGet = $bdd->prepare($preparedRecipeRequest);
    $preparedRequestGet->execute([$reci_id]);
    return $preparedRequestGet->fetchAll();
}

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

function getLastThreeRecipes() {
    $bdd = dbConnect();
    
    $recipeRequest = "SELECT reci_id, reci_title, reci_resume, reci_image
    FROM ptic_recipes
    ORDER BY reci_creation_date DESC LIMIT 3";
    LireDonneesPDO1($bdd, $recipeRequest, $recipes);
    return $recipes;
}

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

function createRecipe($title, $desc, $resume, $categorize) {
    $bdd = dbConnect();
    
    $sql= "INSERT INTO ptic_recipes(reci_title, reci_content, reci_resume, rtype_id, reci_creation_date, reci_edit_date,users_id)
    VALUES (:title, :descr, :resume,(
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), sysdate(), sysdate(),1)";
    $preparedCreateRecipe = $bdd->prepare($sql);
    $preparedCreateRecipe->bindValue(':title', (string) $title, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':descr', (string) $desc, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':resume', (string) $resume, PDO::PARAM_STR);
    $preparedCreateRecipe->bindValue(':cat', (string) $categorize, PDO::PARAM_STR);
    $preparedCreateRecipe->execute();
    return $bdd->lastInsertId();
}

function getConnectionCredentials($email) {
    $bdd = dbConnect();

    $getCredentialsRequest = "SELECT users_nickname, users_password FROM ptic_users WHERE users_email = ?";
    $preparedRequestGet = $bdd->prepare($getCredentialsRequest);
    $preparedRequestGet->execute([$email]);
    return $preparedRequestGet->fetchAll();
}

?>