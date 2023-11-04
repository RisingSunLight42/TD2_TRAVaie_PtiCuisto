<?php
require_once("./assets/php/utils/connexion.php");
include_once("./assets/php/utils/pdo_agile.php");

function getRecipes() {
    $bdd = dbConnect();
    $number = 10;
    if (isset($_POST['number'])) $number = $_POST['number'];
    
    $requete = "select reci_id, reci_title, reci_resume, rtype_title, reci_image
    FROM ptic_recipes
    JOIN ptic_recipes_type USING (rtype_id)
    ORDER BY reci_id LIMIT $number";
    LireDonneesPDO1($bdd, $requete, $recipes);
    return [$recipes, intval($number)];
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

?>