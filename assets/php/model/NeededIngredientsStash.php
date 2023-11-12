<?php
require_once("./assets/php/model/BaseModel.php");
class NeededIngredientsStash extends BaseModel {
    private PDOStatement $preparedGetRecipeStashIngredientsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetRecipeStashIngredients();
    }
    
    /**
     * Method prepareGetRecipeStashIngredients
     * Method to prepare the request to get stash recipe's ingredients.
     * @return void
     */
    final private function prepareGetRecipeStashIngredients() {
        $getRecipeStashIngredientsRequest = "SELECT ing_title
        FROM ptic_needed_ingredients_stash
        JOIN ptic_ingredients USING (ing_id)
        WHERE reci_stash_id = ?";
        $this->preparedGetRecipeStashIngredientsRequest = $this->connection->prepare($getRecipeStashIngredientsRequest);
    }

    /**
     * Method getRecipeIngredients
     * Method to call the prepared request to get stash recipe's ingredients.
     * @param string $reci_id Stash Recipe's id
     *
     * @return array
     */
    final public function getRecipeStashIngredients($reci_id) {
        $this->preparedGetRecipeStashIngredientsRequest->execute([$reci_id]);
        return $this->preparedGetRecipeStashIngredientsRequest->fetchAll();
    }
    
}