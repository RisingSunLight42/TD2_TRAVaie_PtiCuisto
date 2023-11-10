<?php
require_once("./assets/php/utils/connexion.php");
include_once("./assets/php/utils/pdo_agile.php");
/*The model is the treatment part of informations in the database. The controller will use the information to transfer them to the view. 
The treatment was mainly componsed of database's treatment, with selection for the displaying for websites's pages
and insertion for adding a new recipe or ingredient in the database*/ 

/*Recipe retrievment*/
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
/*Get the number total of recipe*/
function getRecipesCount() {
    $bdd = dbConnect();
    $countRequest = "SELECT COUNT(*) as count FROM ptic_recipes";
    LireDonneesPDO1($bdd, $countRequest, $count);
    return $count[0]['count'];
}
/*Retrive one recipe with it's id */
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
/*Treatment of recipe creation*/
function createRecipe() {
    $bdd = dbConnect();
    if(isset($_POST['re_title']) && isset($_POST['re_desc']) && isset($_POST['re_resume']) && isset($_POST['re_cat'])) {
        $title = $_POST['re_title'];
        $desc = $_POST['re_desc'];
        $resume = $_POST['re_resume'];
        $categorize = $_POST['re_cat'];
    }
    $sql= "insert into ptic_recipes(reci_title, reci_content, reci_resume, rtype_id, reci_creation_date, reci_edit_date,users_id) values ('".$title."'".","."'".$desc."'".","."'".$resume."'".",".$categorize.", sysdate(), sysdate(),1)";
    preparerRequetePDO($bdd,$sql);
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

function getConnectionCredentials($email) {
    $bdd = dbConnect();

    $getCredentialsRequest = "SELECT users_nickname, users_password, utype_title FROM ptic_users JOIN ptic_users_type USING (utype_id) WHERE users_email = ?";
    $preparedRequestGet = $bdd->prepare($getCredentialsRequest);
    $preparedRequestGet->execute([$email]);
    return $preparedRequestGet->fetchAll();
}

?>