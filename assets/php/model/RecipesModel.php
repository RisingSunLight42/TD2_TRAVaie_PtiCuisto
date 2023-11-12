<?php
require_once("./assets/php/model/BaseModel.php");
class RecipesModel extends BaseModel {
    private PDOStatement $preparedGetRecipesRequest;
    private PDOStatement $preparedGetRecipeByTitleRequest;
    private PDOStatement $preparedGetRecipesByCategoryRequest;
    private PDOStatement $preparedGetRecipesCount;
    private PDOStatement $preparedGetRecipesByIdRequest;

    public function __construct() {
        parent::__construct();
        $this->prepareGetRecipes();
        $this->prepareGetRecipesByTitle();
        $this->prepareGetRecipesByCategory();
        $this->prepareGetRecipesCount();
        $this->prepareGetRecipesById();
    }
    
    /**
     * Method prepareGetRecipes
     * Method to prepare the request to get recipes depending the number given.
     * @return void
     */
    final private function prepareGetRecipes() {
        $getRecipeRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image, users_nickname
        FROM ptic_recipes
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        ORDER BY reci_id LIMIT :limit";
        $this->preparedGetRecipesRequest = $this->connection->prepare($getRecipeRequest);
    }

    /**
     * Method prepareGetRecipesByTitle
     * Method to prepare the request to get recipes matching the title given.
     * @return void
     */
    final private function prepareGetRecipesByTitle() {
        $getRecipeByTitleRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image, users_nickname
        FROM ptic_recipes
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        WHERE reci_title LIKE UPPER(?)
        ORDER BY reci_id";
    
        $this->preparedGetRecipeByTitleRequest = $this->connection->prepare($getRecipeByTitleRequest);
    }
    
    /**
     * Method prepareGetRecipesByCategory
     * Method to prepare the request to get recipes matching the category given.
     * @return void
     */
    final private function prepareGetRecipesByCategory() {
        $getRecipesByCategoryRequest = "SELECT reci_id, reci_title, reci_resume, rtype_title, reci_image, users_nickname
        FROM ptic_recipes
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        WHERE rtype_title LIKE UPPER(?)
        ORDER BY reci_id";
        $this->preparedGetRecipesByCategoryRequest = $this->connection->prepare($getRecipesByCategoryRequest);
    }
    
    /**
     * Method prepareGetRecipesByIngredients
     * Method to prepare the request to get recipes matching the ingredients given.
     * @return PDOStatement
     */
    final private function prepareGetRecipesByIngredients($ingredients) {
        $getRecipesByIngredientsRequest = "SELECT DISTINCT reci_id, reci_title, reci_resume, rtype_title, reci_image, users_nickname
        FROM ptic_recipes
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        JOIN ptic_needed_ingredients USING (reci_id)
        JOIN ptic_ingredients USING (ing_id)
        WHERE ing_title = UPPER(:ingredient0)";
    
        for ($i=1; $i<count($ingredients); $i++) {
            $getRecipesByIngredientsRequest .= "OR ing_title= UPPER(:ingredient$i)";
        }
        return $this->connection->prepare($getRecipesByIngredientsRequest);
    }

    /**
     * Method prepareGetRecipesCount
     * Method to prepare the request to get the number of recipes existing in the database.
     * @return void
     */
    final private function prepareGetRecipesCount() {
        $getRecipesCount = "SELECT COUNT(*) as count FROM ptic_recipes";
        $this->preparedGetRecipesCount = $this->connection->prepare($getRecipesCount);
    }

    /**
     * Method prepareGetRecipesById
     * Method to prepare the request to get recipe by its id.
     * @return void
     */
    final private function prepareGetRecipesById() {
        $getRecipesByIdRequest = "SELECT reci_title, rtype_title, reci_image, reci_content, users_nickname, reci_resume,
        DATE_FORMAT(reci_creation_date, '%d/%m/%Y à %H:%i:%S') as reci_creation_date, DATE_FORMAT(reci_edit_date, '%d/%m/%Y à %H:%i:%S') as reci_edit_date
        FROM ptic_recipes
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        WHERE reci_id = ?";
        $this->preparedGetRecipesByIdRequest = $this->connection->prepare($getRecipesByIdRequest);
    }
    
    /**
     * Method getRecipes
     * Method to call the prepared request to get a certain number of recipes.
     * @param $number $number The number of recipes to retrieve.
     *
     * @return array
     */
    final public function getRecipes($number) {
        $this->preparedGetRecipesRequest->bindValue(':limit', (int) $number, PDO::PARAM_INT);
        $this->preparedGetRecipesRequest->execute();
        return $this->preparedGetRecipesRequest->fetchAll();
    }
    
    /**
     * Method getRecipesByTitle
     * Method to call the prepared request to get all recipes matching the given title
     * @param $title $title The title to match
     *
     * @return array
     */
    final public function getRecipesByTitle($title) {
        $this->preparedGetRecipeByTitleRequest->execute(['%'.$title.'%']);
        return $this->preparedGetRecipeByTitleRequest->fetchAll();
    }

    /**
     * Method getRecipesByCategory
     * Method to call the prepared request to get all recipes matching the given category
     * @param $category $category The category to match
     *
     * @return array
     */
    final public function getRecipesByCategory($category) {
        $this->preparedGetRecipesByCategoryRequest->execute(['%'.$category.'%']);
        return $this->preparedGetRecipesByCategoryRequest->fetchAll();
    }
    
    /**
     * Method getRecipesByIngredients
     * Method to call the prepared request to get all recipes matching the given ingredients
     * @param $category $category The category to match
     *
     * @return array
     */
    final public function getRecipesByIngredients($ingredients) {
        $preparedGetRecipesByIngredientsRequest = $this->prepareGetRecipesByIngredients($ingredients);
        for ($j=0; $j<count($ingredients); $j++) {
            $preparedGetRecipesByIngredientsRequest->bindValue(":ingredient$j", (string) $ingredients[$j], PDO::PARAM_STR);
        }
        $preparedGetRecipesByIngredientsRequest->execute();
        return $preparedGetRecipesByIngredientsRequest->fetchAll();
    }

    /**
     * Method getRecipesCount
     * Method to call the prepared request to get the number of recipes in the database.
     *
     * @return int
     */
    final public function getRecipesCount() {
        $this->preparedGetRecipesCount->execute();
        return intval($this->preparedGetRecipesCount->fetchAll()[0]['count']);
    }

    /**
     * Method getRecipeById
     * Method to call the prepared request to get the recipe by its id.
     *
     * @return array
     */
    final public function getRecipeById($reci_id) {    
        $this->preparedGetRecipesByIdRequest->execute([$reci_id]);
        return $this->preparedGetRecipesByIdRequest->fetchAll();
    }
    
}