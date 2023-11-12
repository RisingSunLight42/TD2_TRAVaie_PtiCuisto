<?php
require_once("./assets/php/model/BaseModel.php");
class IngredientsModel extends BaseModel {
    private PDOStatement $preparedGetIngredientsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetIngredients();
    }
    
    /**
     * Method prepareGetIngredients
     * Method to prepare the request to get the ingredients.
     * @return void
     */
    final private function prepareGetIngredients() {
        $getLastEditoRequest = "SELECT ing_id, ing_title FROM ptic_ingredients";
        $this->preparedGetIngredientsRequest = $this->connection->prepare($getLastEditoRequest);
    }

    /**
     * Method getIngredients
     * Method to call the prepared request to get the ingredients.
     *
     * @return array
     */
    final public function getIngredients() {
        $this->preparedGetIngredientsRequest->execute();
        return $this->preparedGetIngredientsRequest->fetchAll();
    }
    
}