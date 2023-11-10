<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
    <title>PtiCuistot - Compte</title>
</head>
<body>
    <?php 
        require ("header.php");
    ?>

    <div>
        <button><a href="index.php?action=recipeCreation">Creation</a></button>
        <button><a href="index.php?action=recipeModification">Modification</a></button>
        <button><a href="index.php?action=recipeDeletion">Suppresion</a></button>
    </div>
    <section>
        <?php
        echo $content;
        ?>
    </section>
    <?php 
        require ("footer.php");
    ?>
</body>
</html>