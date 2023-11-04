<?php
function dbConnect() {
    $dotenv = parse_ini_file(".env");
    $DB_TYPE = $dotenv['DB_TYPE'];
    $DB_HOST = $dotenv['DB_HOST'];
    $DB_NAME = $dotenv['DB_NAME'];
    $DB_USER = $dotenv['DB_USER'];
    $DB_PASS = $dotenv['DB_PASS'];
    try {
        $bdd = new PDO("$DB_TYPE:host=$DB_HOST:3306;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASS);
        return $bdd;
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

?>