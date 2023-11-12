<?php
require_once("./assets/php/model/BaseModel.php");
class NeededIngredients extends BaseModel {
    private PDOStatement $preparedGetRecipeIngredientsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetRecipeIngredients();
    }
    
    /**
     * Method prepareGetRecipeIngredients
     * Method to prepare the request to get recipe's ingredients.
     * @return void
     */
    final private function prepareGetRecipeIngredients() {
        $getRecipeIngredientsRequest = "SELECT ing_title
        FROM ptic_needed_ingredients
        JOIN ptic_ingredients USING (ing_id)
        WHERE reci_id = ?";
        $this->preparedGetRecipeIngredientsRequest = $this->connection->prepare($getRecipeIngredientsRequest);
    }

    /**
     * Method getRecipeIngredients
     * Method to call the prepared request to gret recipe's ingredients.
     * @param string $reci_id Recipe's id
     *
     * @return array
     */
    final public function getRecipeIngredients($reci_id) {
        $this->preparedGetRecipeIngredientsRequest->execute([$reci_id]);
        return $this->preparedGetRecipeIngredientsRequest->fetchAll();
    }
    
}