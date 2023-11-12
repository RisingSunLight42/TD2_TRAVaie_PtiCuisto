<?php
session_start();
require('./assets/php/model/model.php');

/* The controller is the part of the MVC who will managed the information flow between the model and the view.
When the user made action on the website, the controller will retrive this information and send it to the model to do treatments*/
/*All recipes's page controller*/ 
function getAllRecipes($textSupp="") {
    $number = 10;
    if (isset($_POST['number']) && is_numeric($_POST['number'])) $number = strip_tags(intval($_POST['number']));
    $recipes = getRecipes($number);
    $count = getRecipesCount();
    $content = "$textSupp";
    buildRecipeDisplayAllRecipes($content, $recipes);
    if ($count > $number) {
        $number += 10;
        $content .= "<form action='' method='post'><input type='hidden' id='number' name='number' value='$number' /><input type='submit' value='Afficher plus' /></form>";
    }
    require('./assets/php/views/allRecipesView.php');
}

function buildRecipeDisplayAllRecipes(&$content, $recipes, $isStash=false) {
    $optionalButtons = "";
    $action = $isStash ? "recipeStash" : "recipe";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        if (!$isStash && checkCanEditOrDelete($recipe["users_nickname"])) {
            $optionalButtons .= "<div class='editButton'><button><a href='index.php?action=recipeEdition&value=RECI_ID'>Modification</a></button>";
            $optionalButtons .= "<button><a href='index.php?action=recipeDeletion&value=RECI_ID'>Suppression</a></button></div>";
        }
        $recipe_id = $recipe['reci_id'];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $type = $recipe['rtype_title'];
        $image = $recipe['reci_image'];
        $anchor = $i + 1;
        $content .= "<article id='$anchor' class='recipeCard'>";
        $content .= "<div id='leftRecipeCard'>";
        $content .= "<div id='recipePicture'>";
        $content .= "<img class='pointer recipePicture' src='$image' alt='image de recette' onclick=\"location.href='index.php?action=$action&value=$recipe_id'\"/>";
        $content .= "</div>";
        $content .= "<div id='tags'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "<div id='rightRecipeCard'>";
        $content .= "<h1 class='pointer' onclick=\"location.href='index.php?action=$action&value=$recipe_id'\" >$title</h1>";
        $content .= "<h2>$type</h2>";
        $content .= "<h2>Résumé</h2>";
        $content .= "<p>$resume</p>";
        $content .= "</div>";
        $content .= str_replace("RECI_ID", $recipe_id, $optionalButtons);
        $content .= "</article>";
        $optionalButtons = "";
    }
}

function welcome() {
    $recipes = getLastThreeRecipes();

    // Latest recipes building
    $content = "<section id='lastestRecipes'>";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        $recipe_id = $recipe['reci_id'];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $image = $recipe['reci_image'];
        $content .= "<div class='card mb-3'>";
        $content .= "<div class='row g-0'>";
        $content .= "<div class='col-md-4'>";
        $content .= "<img src='$image' class='img-recipes img-fluid rounded pointer' alt='image de recette' onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\"/>" ;
        $content .= "</div>";
        $content .= "<div class='col-md-8'>";
        $content .= "<div class='card-body'>";
        $content .= "<h5 class='pointer' onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" >$title</h5>";
        $content .= "<p>$resume<p>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</div>";         
        $content .= "</div>";         
    }

    // Edito building
    $editoText = str_replace("\n", "<br>", getLastEdito());
    $edito = "<p>$editoText</p>";
    require('./assets/php/views/welcomeView.php');
}

function buildRecipeDisplayOneRecipe($recipe, $ingredients, &$content) {
    // Ingredients building format
    $ingredientsHTML = "";
    if (!empty($ingredients)) {
        $ingredientsHTML = "<h2>Ingrédients nécessaires</h2><p>";
        $nbIngredients = count($ingredients);
        for ($i= 0; $i < $nbIngredients - 1; $i++){
            $ingredientsHTML .= $ingredients[$i]['ing_title'].", ";
        }
        $ingredientsHTML .= $ingredients[$nbIngredients - 1]['ing_title'].".";
        $ingredientsHTML .= "</p>";
    }

    // Recipe building format
    $title = $recipe['reci_title'];
    $type = $recipe['rtype_title'];
    $reci_content = $recipe['reci_content'];
    $reci_content = str_replace("\n", "<br>", $reci_content);
    $image = $recipe['reci_image'];
    $creationDate = $recipe['reci_creation_date'];
    $lastUpdateDate = $recipe['reci_edit_date'];
    $editorUsername = $recipe['users_nickname'];

    $content .= "<h1>$title</h1>";
    $content .= "<p>$type</p>";
    $content .= "<img src='$image' alt='image de recette' width=200px height=200px/>" ;
    $content .= $ingredientsHTML;
    $content .= "<h2>Recette</h2><p>$reci_content</p>";
    $content .= "<p>Créé le : $creationDate par $editorUsername</p>";
    $content .= "<p>Édité pour la dernière fois le : $lastUpdateDate</p>";
}

/*recipe's page controller */
function recipe($reci_id="") {
    if ($reci_id===""){
        if (empty($_GET['value'])) welcome();
        $reci_id = strip_tags($_GET['value']);
    }
    if (!is_numeric($reci_id)) return getAllRecipes();
    if (intval($reci_id) < 1) return getAllRecipes();
    $recipe = getRecipeById($reci_id);
    if (empty($recipe)) getAllRecipes();
    $recipe = $recipe[0];
    $ingredients = getRecipeIngredients($reci_id);

    buildRecipeDisplayOneRecipe($recipe, $ingredients, $content);
    if (checkCanEditOrDelete($recipe['users_nickname'])) {
        $content .= "<div class='editButton'><button><a href='index.php?action=recipeEdition&value=$reci_id'>Modification</a></button>";
        $content .= "<button><a href='index.php?action=recipeDeletion&value=$reci_id'>Suppression</a></button></div>";
    }
    require('./assets/php/views/recipeView.php');
}

/*recipe stash's page controller */
function recipeStash($reci_stash_id="") {
    $content = "<h1>Nouvelle recette</h1>";
    if ($reci_stash_id===""){
        if (empty($_GET['value'])) welcome();
        $reci_stash_id = strip_tags($_GET['value']);
    }
    if (!is_numeric($reci_stash_id)) return getAllRecipes();
    if (intval($reci_stash_id) < 1) return getAllRecipes();
    $recipeStash = getOneRecipeStash($reci_stash_id);
    if (empty($recipeStash)) getAllRecipes();
    $recipeStash = $recipeStash[0];
    $ingredientsStash = getRecipeStashIngredients($reci_stash_id);
    buildRecipeDisplayOneRecipe($recipeStash, $ingredientsStash, $content);
    

    $reci_id = $recipeStash["reci_id"];
    if (is_numeric($reci_id)) {
        $content .= "<h1>Ancienne version de la recette</h1>";
        $recipe = getRecipeById($reci_id);
        if (empty($recipe)) getAllRecipes();
        $recipe = $recipe[0];
        $ingredients = getRecipeIngredients($reci_id);
        buildRecipeDisplayOneRecipe($recipe, $ingredients, $content);
    }
    
    $content .= "<button><a href='index.php?action=validate&value=$reci_stash_id'>Valider</a></button>";
    $content .= "<button><a href='index.php?action=refuse&value=$reci_stash_id'>Refuser</a></button>";
    require('./assets/php/views/recipeView.php');
}

/* To refuse a stash*/
function refuse() {
    if (empty($_SESSION["connected"]) || $_SESSION["connected"] = false) return welcome();
    if (strcmp($_SESSION['userType'],"ADMINISTRATEUR") != 0) return welcome();
    if (empty($_GET['value'])) account();
    $reci_stash_id = strip_tags($_GET['value']);
    deleteRecipeStash($reci_stash_id);
    account();
}

/* To validate a stash */
function validate() {
    if (empty($_SESSION["connected"]) || $_SESSION["connected"] = false) return welcome();
    if (strcmp($_SESSION['userType'],"ADMINISTRATEUR") != 0) return welcome();
    if (empty($_GET['value'])) account();
    $reci_stash_id = strip_tags($_GET['value']);
    $recipeStash = getOneRecipeStash($reci_stash_id);
    $recipeStash = $recipeStash[0];
    if ($recipeStash["stash_type_value"] === "CREATION") {
        $reci_id = createRecipe($recipeStash["reci_title"], $recipeStash["reci_content"],
        $recipeStash["reci_resume"], $recipeStash["rtype_title"], $recipeStash["reci_image"], $recipeStash["users_nickname"], true);
        $ingredientsStash = getRecipeStashIngredients($reci_stash_id);
        $ingredients = array();
        foreach($ingredientsStash as $key => $value) {
            array_push($ingredients,$value["ing_title"]);
        }
        addRecipesIngredients($reci_id, $ingredients, true);
        deleteRecipeStash($reci_stash_id);
        account();
    } elseif ($recipeStash["stash_type_value"] === "MODIFICATION") {
        editRecipe($recipeStash["reci_id"], $recipeStash["reci_title"], $recipeStash["reci_content"],
        $recipeStash["reci_resume"], $recipeStash["rtype_title"], $recipeStash["reci_image"], $recipeStash["users_nickname"], true);
        $ingredientsStash = getRecipeStashIngredients($reci_stash_id);
        $ingredients = array();
        foreach($ingredientsStash as $key => $value) {
            array_push($ingredients,$value["ing_title"]);
        }
        editRecipesIngredients($recipeStash["reci_id"], $ingredients, true);
        deleteRecipeStash($reci_stash_id);
        account();
    }
}

/*filter's page controller*/
function filter() {
    $content = "";
    $action = strip_tags($_GET["action"]);
    $recipes = array();
    if ($action === "filterRecipeName") {
        if (empty($_POST["title"])) {
            $content="Veuillez renseigner un titre pour réaliser un filtrage !";
            require('./assets/php/views/filterView.php');
            return;
        }
        $titleFilter = $_POST["title"];
        $recipes = getRecipesByTitle($titleFilter);
    } elseif ($action === "filterRecipeCategory") {
        if (empty($_POST["re_cat"])) {
            $content="Veuillez renseigner une catégorie pour réaliser un filtrage !";
            require('./assets/php/views/filterView.php');
            return;
        }
        $categoryFilter = $_POST["re_cat"];
        $recipes = getRecipesByCategory($categoryFilter);
    } elseif ($action === "filterRecipeIngredients") {
        $ingredients = array();
        foreach($_POST as $key => $value) {
            if (preg_match('/ingredient\d+/', $key)) array_push($ingredients, strip_tags($value));
        }
        if(count($ingredients) === 0) {
            $content = "Veuillez mettre au moins un ingrédient s'il vous plaît !";
            require('./assets/php/views/filterView.php');
            return;
        }
        $recipes = getRecipesByIngredients($ingredients);
    }
    if (count($recipes) === 1) {
        $reci_id = $recipes[0]["reci_id"];
        return recipe($reci_id);
    }
    buildRecipeDisplayAllRecipes($content, $recipes);
    require('./assets/php/views/filterView.php');
}
/*account's page controller*/
function account() {
    $content = "";
    $unlogButton = "";
    if (isset($_SESSION['connected']) && boolval($_SESSION['connected']) === true) {
        $unlogButton = '<button><a href="index.php?action=disconnect">Déconnexion</a></button>';
        if (strcmp($_SESSION['userType'],"ADMINISTRATEUR") === 0) {
            $content .= "<h1>Modification de l'édito</h1>";
            $content .= "<form id='form_edito' name='edito' method='post' action='index.php?action=editoEdition'>";
            $content .= "<label for='edito'>Entrez le nouveau texte de l'édito :</label><textarea name='edito' rows='10' required></textarea>";
            $content .= "<input type='submit' name='confirm' value='OK'/></form>";
            $content .= "<h1>Demandes d'ajout</h1>";
            $recipesCreation = getWaitingForCreationRecipes();
            buildRecipeDisplayAllRecipes($content, $recipesCreation, true);
            $content .= "<h1>Demandes de modification</h1>";
            $recipesEdition = getWaitingForModificationRecipes();
            buildRecipeDisplayAllRecipes($content, $recipesEdition, true);
        }
        require('./assets/php/views/accountView.php');
        return;
    }
    require('./assets/php/views/connectionView.php');
}


function checkCanEditOrDelete($username) {
    return (isset($_SESSION["userType"]) && strcmp($_SESSION["userType"],"ADMINISTRATEUR") === 0) ||
    (isset($_SESSION["username"]) && strcmp($_SESSION["username"], $username) === 0 && $_SESSION["userType"] = "EDITEUR");
}

/* */
function disconnect() {
    $_SESSION['connected'] = false;
    unset($_SESSION['username']);
    unset($_SESSION['userType']);
    welcome();
}

function checkIfConnectionValuesExists(&$content) {
    /* Commented code, only works in PHP8+
    This code is usefull since it's more open/close than a basic if/else structure

    $errorMessageFunction = function(&$content, $errorText) {
        $content .= $errorText;
        return true;
    };
    $requiredFieldMissing = false;
    $requiredFieldMissing = match (true) {
        (empty($_POST['username'])) => $errorMessageFunction($content, "<p>username manquant !</p>"),
        (empty($_POST['password'])) => $errorMessageFunction($content, "<p>Mot de passe manquant !</p>"),
        default => false,
    };
    if ($requiredFieldMissing) {
        require('./assets/php/views/connectionView.php');
        return;
    }*/
    $fieldsMissing = 0;
    if (empty($_POST['username'])) {
        $content .= "<p>Nom d'utilisateur manquant !</p>";
        $fieldsMissing++;
    }
    if (empty($_POST['password'])) {
        $content .= "<p>Mot de passe manquant !</p>";
        $fieldsMissing++;
    }
    return $fieldsMissing;
}

/*Connection's page controller*/
function connectionForm() {
    $content = "";
    $fieldsMissing = checkIfConnectionValuesExists($content);
    if ($fieldsMissing > 0) {
        require('./assets/php/views/connectionView.php');
        return;
    }

    $givenUsername = strip_tags($_POST['username']);
    $givenPassword = strip_tags($_POST['password']);

    $returnedCredentials = getConnectionCredentials($givenUsername);
    if (empty($returnedCredentials)) {
        $content .= "Nom d'utilisateur incorrect !";
        require('./assets/php/views/connectionView.php');
        return;
    }
    [$storedUsername, $storedPassword, $storedUserType] = $returnedCredentials[0];
    if (!password_verify($givenPassword, $storedPassword)) {
        $content .= "Mot de passe incorrect !";
        require('./assets/php/views/connectionView.php');
        return;
    }

    $_SESSION['username'] = $storedUsername;
    $_SESSION['userType'] = $storedUserType;
    $_SESSION['connected'] = true;

    $unlogButton = '<button><a href="index.php?action=disconnect">Déconnexion</a></button>';
    $content .= "<p>Connexion réussie. Bienvenue $storedUserType $storedUsername !</p>";
    if (strcmp($_SESSION['userType'],"ADMINISTRATEUR") === 0) {
        $content .= "<h1>Modification de l'édito</h1>";
        $content .= "<form id='form_edito' name='edito' method='post' action='index.php?action=editoEdition'>";
        $content .= "<label for='edito'>Entrez le nouveau texte de l'édito :</label><textarea name='edito' rows='10' required></textarea>";
        $content .= "<input type='submit' name='confirm' value='OK'/></form>";
        $content .= "<h1>Demandes de création</h1>";
        $recipesCreation = getWaitingForCreationRecipes();
        buildRecipeDisplayAllRecipes($content, $recipesCreation, true);
        $content .= "<h1>Demandes de modification</h1>";
        $recipesEdition = getWaitingForModificationRecipes();
        buildRecipeDisplayAllRecipes($content, $recipesEdition, true);
    }
    require('./assets/php/views/accountView.php');
}
/*recipe creation controller*/
function recipeCreation() {
    $content = "";
    require('./assets/php/views/recipeCreationView.php');
}

function getAllIngredients() {
    $ingredients = getIngredients();
    $ingredientsList = "";
    for ($i= 0; $i < count($ingredients); $i++){
        $ingredientsList .= $ingredients[$i]['ing_title'].',';
    }
    echo $ingredientsList;
}

function recipeCreationHandling() {
    if(empty($_POST['re_title']) || empty($_POST['re_desc']) || empty($_POST['re_resume']) || empty($_POST['re_cat'])) {
        $content = "Veuillez remplir tous les champs obligatoires !";
        require('./assets/php/views/recipeCreationView.php');
        return;
    }
    $title = strip_tags($_POST['re_title']);
    $desc = strip_tags($_POST['re_desc']);
    $resume = strip_tags($_POST['re_resume']);
    $categorize = strip_tags($_POST['re_cat']);
    $image = "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1200px-No_image_available.svg.png";
    if (!empty($_POST['re_img'])) {
        if (preg_match('/(https?:\/\/.*\.(?:png|jpg|webp|jpeg))/i', $_POST['re_img'])) $image = strip_tags($_POST['re_img']);
        else {
            $content = "Le lien que vous avez fourni est invalide. Les formats acceptés sont jpg/jpeg/png/webp.";
            require('./assets/php/views/recipeCreationView.php');
            return;
        }
    }

    $ingredients = array();
    foreach($_POST as $key => $value) {
        if (preg_match('/ingredient\d+/', $key)) array_push($ingredients, strip_tags($value));
    }
    if(count($ingredients) === 0) {
        $content = "Veuillez mettre au moins un ingrédient s'il vous plaît !";
        require('./assets/php/views/recipeCreationView.php');
        return;
    }
    $reci_id = createRecipe($title, $desc, $resume, $categorize, $image, $_SESSION["username"], strcmp($_SESSION["userType"], "ADMINISTRATEUR") === 0);
    addRecipesIngredients($reci_id, $ingredients, strcmp($_SESSION["userType"], "ADMINISTRATEUR") === 0);
    getAllRecipes();
}
/*recipe modification controller*/
function recipeEdition($text="") {
    $content = "$text";
    $reci_id = strip_tags($_GET['value']);
    $recipe = getRecipeById($reci_id);
    if (count($recipe) === 0) return welcome();
    if (!checkCanEditOrDelete($recipe[0]["users_nickname"])) return welcome(); 
    $recipeIngredients = getRecipeIngredients($reci_id);
    $title = $recipe[0]["reci_title"];
    $description = $recipe[0]["reci_content"];
    $img = $recipe[0]["reci_image"];
    $resume = $recipe[0]["reci_resume"];
    $ingredients = "";
    $type = $recipe[0]["rtype_title"];
    $entry = "";
    $dish = "";
    $dessert = "";
    $aperitif = "";
    $drink = "";
    switch ($type) {
        case "ENTREE":
            $entry = "checked";
            break;
        case "PLAT":
            $dish = "checked";
            break;
        case "DESSERT":
            $dessert = "checked";
            break;
        case "APERITIF":
            $aperitif = "checked";
            break;
        case "BOISSON":
            $drink = "checked";
            break;
    }
    for ($i=0; $i< count($recipeIngredients); $i++) {
        $ing = $recipeIngredients[$i]['ing_title'];
        $num = $i + 1;
        $ingredients .= "<div class='div-ingredient'>";
        $ingredients .= "<input id='ingredient$num' name='ingredient$num' type='hidden' value='$ing'>";
        $ingredients .= "<p class='ingredient'>$ing</p>";
        $ingredients .= "<em class='fa-solid fa-xmark fa-2x'></em>";
        $ingredients .= "</div>";
    }
    $nbIngredients = count($recipeIngredients);
    require('./assets/php/views/recipeEditionView.php');
}

function recipeEditionHandling() {
    $reci_id = strip_tags($_GET['value']);
    if(empty($_POST['re_title']) || empty($_POST['re_desc']) || empty($_POST['re_resume']) || empty($_POST['re_cat'])) {
        $content = "Veuillez remplir tous les champs obligatoires !";
        return recipeEdition($content);
    }
    $title = strip_tags($_POST['re_title']);
    $desc = strip_tags($_POST['re_desc']);
    $resume = strip_tags($_POST['re_resume']);
    $categorize = strip_tags($_POST['re_cat']);
    $image = "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1200px-No_image_available.svg.png";
    if (!empty($_POST['re_img'])) {
        if (preg_match('/(https?:\/\/.*\.(?:png|jpg|webp|jpeg))/i', $_POST['re_img'])) $image = strip_tags($_POST['re_img']);
        elseif (preg_match('/\.\/assets\/images\/recette\/.*\.(?:png|jpg|webp|jpeg)/i', $_POST['re_img'])) $image = strip_tags($_POST['re_img']);
        else {
            $content = "Le lien que vous avez fourni est invalide. Les formats acceptés sont jpg/jpeg/png/webp.";
            return recipeEdition($content);
        }
    }

    $ingredients = array();
    foreach($_POST as $key => $value) {
        if (preg_match('/ingredient\d+/', $key)) array_push($ingredients, strip_tags($value));
    }
    if(count($ingredients) === 0) {
        $content = "Veuillez mettre au moins un ingrédient s'il vous plaît !";
        return recipeEdition($content);
    }
    if (strcmp($_SESSION["userType"], "ADMINISTRATEUR") === 0) {
        editRecipe($reci_id, $title, $desc, $resume, $categorize, $image, $_SESSION["username"], true);
        editRecipesIngredients($reci_id, $ingredients, true);
    } else {
        $reci_stash_id = editRecipe($reci_id, $title, $desc, $resume, $categorize, $image, $_SESSION["username"], false);
        editRecipesIngredients($reci_stash_id, $ingredients, false);
    }
    
    getAllRecipes();
}

/*recipe deletion controller*/
function recipeDeletion() {
    if (empty($_GET['value'])) getAllRecipes();
    $reci_id = strip_tags($_GET['value']);
    $recipe = getRecipeById($reci_id);
    if (!$recipe) return getAllRecipes();
    if (!checkCanEditOrDelete($recipe[0]['users_nickname'])) return getAllRecipes();
    deleteRecipe($reci_id);
    getAllRecipes("<p>La recette a bien été supprimée !</p>");
}

function editoEdition() {
    $content = "";
    if (empty($_POST["edito"])) {
        $content .= "Veuillez remplir le contenu de l'édito s'il vous plait.";
        $content .= "<h1>Modification de l'édito</h1>";
        $content .= "<form id='form_edito' name='edito' method='post' action='index.php?action=editoEdition'>";
        $content .= "<label for='edito'>Entrez le nouveau texte de l'édito :</label><textarea name='edito' rows='10' required></textarea>";
        $content .= "<input type='submit' name='confirm' value='OK'/></form>";
        require('./assets/php/views/accountView.php');
    }
    $edito = strip_tags($_POST["edito"]);
    addEdito($edito);
    welcome();
}
?>