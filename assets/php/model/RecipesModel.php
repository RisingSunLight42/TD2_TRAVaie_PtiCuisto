<?php
require_once("./assets/php/model/BaseModel.php");
class RecipesModel extends BaseModel {
    private PDOStatement $preparedGetRecipesRequest;
    private PDOStatement $preparedGetRecipeByTitleRequest;

    public function __construct() {
        parent::__construct();
        $this->prepareGetRecipes();
        $this->prepareGetRecipesByTitle();
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
     * Method prepareGetRecipes
     * Method to prepare the request to get recipes matching the title given.s
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
    
}