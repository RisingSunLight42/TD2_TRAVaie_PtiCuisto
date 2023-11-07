<?php
require_once("./assets/php/utils/connexion.php");
include_once("./assets/php/utils/pdo_agile.php");

function getRecipes() {
    $bdd = dbConnect();
    $number = 10;
    if (isset($_POST['number'])) $number = $_POST['number'];
    
    $recipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    ORDER BY reci_id LIMIT $number";
    LireDonneesPDO1($bdd, $recipeRequest, $recipes);

    $countRequest = "SELECT COUNT(*) as count FROM ptic_recipes";
    LireDonneesPDO1($bdd, $countRequest, $count);
    return [$recipes, intval($number), $count[0]['count']];
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

function getConnectionCredentials($email) {
    $bdd = dbConnect();

    $getCredentialsRequest = "SELECT users_nickname, users_password FROM ptic_users WHERE users_email = ?";
    $preparedRequestGet = $bdd->prepare($getCredentialsRequest);
    $preparedRequestGet->execute([$email]);
    return $preparedRequestGet->fetchAll();
}

?>