<?php
require_once("connexion.php");
require_once("pdo_agile.php");


if(isset($_POST['re_title']) && isset($_POST['re_desc']) && isset($_POST['re_resume']) && isset($_POST['re_cat'])) {
    $title = $_POST['re_title'];
    $desc = $_POST['re_desc'];
    $resume = $_POST['re_resume'];
    $categorize = $_POST['re_cat'];
}
$sql= "insert into ptic_recipes(reci_title, reci_content, reci_resume, rtype_id, reci_creation_date, reci_edit_date,users_id) values ('".$title."'".","."'".$desc."'".","."'".$resume."'".",".$categorize.", sysdate(), sysdate(),1)";
preparerRequetePDO($bdd,$sql)
?>