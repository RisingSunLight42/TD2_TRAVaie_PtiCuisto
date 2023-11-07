<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="icon" href="assets/images/Pticuisto_icon.ico"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <title>PtiCuistot - Accueil</title>
</head>
<body>
    <header>
        <nav id="navBar">
            <div>
                <a href="#">
                <img id="logo" src="assets/images/Logo.png" alt="Logo PtitCuisto" width="20%" height="20%">
                </a>
            </div>
            <div>
                <ul id="websiteLinks">
                    <li>
                        <a href="index.php?action=welcome">Accueil</a>
                    </li>
                    <li>
                        <a href="index.php?action=allRecipes">Nos Recettes</a>
                    </li>
                    <li>
                        <a href="index.php?action=filter">Filtres</a>
                    </li>
                    <li>
                        <a href="index.php?action=account">Connexion</a>

                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <article id="lastRecipes">
                <h2>LES DERNIÈRES RECETTES</h2>
                <?php
                echo $content;
                ?>
            </article>
            <article id="edito">
                <img id="imgEdito" src="assets/images/Pticuisto.png" class="img-fluid rounded-start" alt="...">
                <h2>Edito</h2>
                
                <?php
                echo $edito;
                ?>
            </article>
        </section>
    </main>    
    <footer>
        <div >
            <ul id="socialLinks">
                <li>
                    <a target="_blank" href="https://www.facebook.com/ptitcuisto.fr">
                        <img id="facebook" src="assets/images/Facebook_icon.svg" alt="Facebook_icon">
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://twitter.com/ptitcuisto">
                        <img id="twitter" src="assets/images/twitter.png" alt="Twitter_icon">
                    </a>
                </li>
                <li>
                    <a target="_blank">
                        <img id="linkedin" src="assets/images/linkedin.png" alt="LinkedIn_icon">
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <script src="assets/scripts/bootstrap.js" type="text/javascrit"></script>
</body>
</html>