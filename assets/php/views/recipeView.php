<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php 
        require ("head.php");
    ?>
    <title>Recette</title>
</head>
<body>
    <?php 
        require ("header.php");
    ?>
    <main>
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