<?php
require_once("./assets/php/model/BaseModel.php");
require_once("./assets/php/model/NeededIngredientsStash.php");
class NeededIngredients extends BaseModel {
    private PDOStatement $preparedGetRecipeIngredientsRequest;
    private PDOStatement $preparedAddRecipesIngredientsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetRecipeIngredients();
        $this->prepareAddRecipesIngredients();
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
     * Method prepareAddRecipesIngredients
     * Method to prepare the request to add the ingredients of a recipe.
     * @return void
     */
    final private function prepareAddRecipesIngredients() {
        $addRecipesIngredientsRequest = "INSERT INTO ptic_needed_ingredients (reci_id, ing_id) VALUES (?, (
            SELECT ing_id
            FROM ptic_ingredients
            WHERE TRIM(UPPER(ing_title)) = TRIM(UPPER(?))
            )
        )";
        $this->preparedAddRecipesIngredientsRequest = $this->connection->prepare($addRecipesIngredientsRequest);
    }

    /**
     * Method getRecipeIngredients
     * Method to call the prepared request to get recipe's ingredients.
     * @param string $reci_id Recipe's id
     *
     * @return array
     */
    final public function getRecipeIngredients($reci_id) {
        $this->preparedGetRecipeIngredientsRequest->execute([$reci_id]);
        return $this->preparedGetRecipeIngredientsRequest->fetchAll();
    }
    
    /**
     * Method addRecipesIngredients
     * Method to call the prepared request to add recipe's ingredients.
     * @param string $reci_id Recipe's id
     * @param array $ingredients List of the ingredients to add
     *
     * @return void
     */
    final public function addRecipesIngredients($reci_id, $ingredients) {
        if ($this->isAdmin) {
            for ($i= 0; $i < count($ingredients); $i++) {
                $this->preparedAddRecipesIngredientsRequest->execute([$reci_id, $ingredients[$i]]);
            }
            return;
        }
        $neededIngredientsStashModel = new NeededIngredientsStash($this->isAdmin, $this->connection);
        $neededIngredientsStashModel->addRecipesStashIngredients($reci_id, $ingredients);
    }
}