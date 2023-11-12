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
<body class="d-flex flex-column min-vh-100">
    <?php 
        require ("header.php");
    ?>
    <main>
        <div>
            <button><a href="index.php?action=recipeCreation">Creation</a></button>
            <?php
                echo $unlogButton
            ?>
        </div>
        <section>
            <?php
            echo $content;
            ?>
        </section>
    </main>
    <?php 
        require ("footer.php");
    ?>
</body>
</html>