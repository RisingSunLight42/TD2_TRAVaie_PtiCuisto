<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        require ("head.php");
    ?>
    <title>Nos recettes</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
        require ("header.php");
    ?>
    <main>
        <section id="allRecipesSection">
            <?php
            echo $content;
            if ($number > 20) {
                $anchor = $number - 20;
                echo "<script type='text/javascript'>",
                "window.location.href = '#$anchor';",
                "</script>";
                ;
            }
            ?>
        </section>
    </main>
    <?php 
        require ("footer.php");
    ?>
</body>
</html>