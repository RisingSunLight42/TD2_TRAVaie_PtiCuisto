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
<body>
    <?php 
        require ("header.php");
    ?>

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
    <?php 
        require ("footer.php");
    ?>
</body>
</html>