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
    $deleteButton = "";
    if (isset($_SESSION["userType"]) && $_SESSION["userType"] = "ADMINISTRATEUR") {
        $deleteButton .= "<button><a href='index.php?action=recipeDeletion&value=RECI_ID'>Suppression</a></button>";
    }
    $count = getRecipesCount();
    $content = "$textSupp";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        $recipe_id = $recipe['reci_id'];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $type = $recipe['rtype_title'];
        $image = $recipe['reci_image'];
        $anchor = $i + 1;
        $content .= "<div id='$anchor'>";
        $content .= "<img src='$image' alt='image de recette' onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" width=50px height=50px/>" ;
        $content .= "<h1 onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" >$title</h1>";
        $content .= "<h2>$type</h2>";
        $content .= "<p>$resume<p>";
        $content .= str_replace("RECI_ID", $recipe_id, $deleteButton);
        $content .= "</div>";           
    }
    if ($count > $number) {
        $number += 10;
        $content .= "<form action='' method='post'><input type='hidden' id='number' name='number' value='$number' /><input type='submit' value='Afficher plus' /></form>";
    }
    require('./assets/php/views/allRecipesView.php');
}

function welcome() {
    $recipes = getLastThreeRecipes();

    // Latest recipes building
    $content = "<section id='lastestRecipes'>";
    $content .= "<h1>Les dernières recettes</h1>";
    for ($i= 0; $i < count($recipes); $i++){
        $recipe = $recipes[$i];
        $recipe_id = $recipe['reci_id'];
        $title = $recipe['reci_title'];
        $resume = $recipe['reci_resume'];
        $image = $recipe['reci_image'];
        $content .= "<div>";
        $content .= "<img src='$image' alt='image de recette' onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" width=200px height=200px/>" ;
        $content .= "<h2 onclick=\"location.href='index.php?action=recipe&value=$recipe_id'\" >$title</h2>";
        $content .= "<p>$resume<p>";
        $content .= "</div>";           
    }
    $content .= "</section>";

    // Edito building
    $editoText = str_replace("\n", "<br>", getLastEdito());
    $content .= "<section id='edito'>";
    $content .= "<h1>Edito</h1>";
    $content .= "<p>$editoText</p></section>";
    require('./assets/php/views/welcomeView.php');
}
/*recipe's page controller */
function recipe() {
    if (empty($_GET['value'])) welcome();
    $reci_id = strip_tags($_GET['value']);
    if (!is_numeric($reci_id)) return getAllRecipes();
    if (intval($reci_id) < 1) return getAllRecipes();
    $recipe = getOneRecipe($reci_id);
    if (empty($recipe)) getAllRecipes();
    $recipe = $recipe[0];
    $ingredients = getRecipeIngredients($reci_id);

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
    $content = "<h1>$title</h1>";
    $content .= "<p>$type</p>";
    $content .= $ingredientsHTML;
    $content .= "<h2>Recette</h2><p>$reci_content</p>";
    $content .= "<p>Créé le : $creationDate par $editorUsername</p>";
    $content .= "<p>Édité pour la dernière fois le : $lastUpdateDate</p>";
    $content .= "<img src='$image' alt='image de recette' width=200px height=200px/>" ;
    if (isset($_SESSION["userType"]) && $_SESSION["userType"] = "ADMINISTRATEUR") {
        $content .= "<button><a href='index.php?action=recipeDeletion&value=$reci_id'>Suppression</a></button>";
    }
    require('./assets/php/views/recipeView.php');
}
/*filter's page controller*/
function filter() {
    require('./assets/php/views/filterView.php');
}
/*account's page controller*/
function account() {
    $content = "";
    $unlogButton = "";
    if (isset($_SESSION['connected']) && boolval($_SESSION['connected']) === true) {
        $unlogButton = '<button><a href="index.php?action=disconnect">Déconnexion</a></button>';
        require('./assets/php/views/accountView.php');
        return;
    }
    require('./assets/php/views/connectionView.php');
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
        (empty($_POST['email'])) => $errorMessageFunction($content, "<p>Email manquant !</p>"),
        (empty($_POST['password'])) => $errorMessageFunction($content, "<p>Mot de passe manquant !</p>"),
        default => false,
    };
    if ($requiredFieldMissing) {
        require('./assets/php/views/connectionView.php');
        return;
    }*/
    $fieldsMissing = 0;
    if (empty($_POST['email'])) {
        $content .= "<p>Email manquant !</p>";
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

    $givenEmail = strip_tags($_POST['email']);
    $givenPassword = strip_tags($_POST['password']);

    $returnedCredentials = getConnectionCredentials($givenEmail);
    if (empty($returnedCredentials)) {
        $content .= "Email incorrect !";
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
    require('./assets/php/views/accountView.php');
}
/*recipe creation controller*/
function recipeCreation() {
    require('./assets/php/views/recipeCreationView.php');
}

function recipeCreationHandling() {
    require('./assets/php/views/recipeCreationHandlingView.php');
}
/*recipe modification controller*/
function recipeModification() {
    require('./assets/php/views/recipeModificationView.php');
}
/*recipe deletion controller*/
function recipeDeletion() {
    if (empty($_GET['value'])) getAllRecipes();
    $reci_id = strip_tags($_GET['value']);
    deleteRecipe($reci_id);
    getAllRecipes("<p>La recette a bien été supprimée !</p>");
}
?>