<?php
    try {
        $bdd = new PDO('mysql:host=host;dbname=bd;charset=utf8', 'id', 'password');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
?>