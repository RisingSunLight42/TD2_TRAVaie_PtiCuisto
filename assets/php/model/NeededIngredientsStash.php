<?php
require_once("./assets/php/model/BaseModel.php");
class NeededIngredientsStash extends BaseModel {
    private PDOStatement $preparedGetRecipeStashIngredientsRequest;
    private PDOStatement $preparedAddRecipesStashIngredientsRequest;
    private PDOStatement $preparedDeleteStashRecipesIngredientsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetRecipeStashIngredients();
        $this->prepareAddRecipesStashIngredients();
        $this->prepareDeleteStashRecipesIngredients();
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
     * Method prepareAddRecipesStashIngredients
     * Method to prepare the request to add the ingredients of a stash recipe.
     * @return void
     */
    final private function prepareAddRecipesStashIngredients() {
        $addRecipesStashIngredientsRequest = "INSERT INTO ptic_needed_ingredients_stash (reci_stash_id, ing_id) VALUES (?, (
            SELECT ing_id
            FROM ptic_ingredients
            WHERE TRIM(UPPER(ing_title)) = TRIM(UPPER(?))
            )
        )";
        $this->preparedAddRecipesStashIngredientsRequest = $this->connection->prepare($addRecipesStashIngredientsRequest);
    }

    /**
     * Method prepareAddRecipesIngredients
     * Method to prepare the request to add the ingredients of a recipe.
     * @return void
     */
    final private function prepareDeleteStashRecipesIngredients() {
        $deleteStashRecipesIngredientsRequest = "DELETE FROM ptic_needed_ingredients_stash WHERE reci_stash_id = ?";
        $this->preparedDeleteStashRecipesIngredientsRequest = $this->connection->prepare($deleteStashRecipesIngredientsRequest);
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

    /**
     * Method addRecipesStashIngredients
     * Method to call the prepared request to add stash recipe's ingredients.
     * @param string $reci_stash_id Stash Recipe's id
     * @param array $ingredients List of the ingredients to add
     * @param bool $isAdmin If the user is admin or not
     *
     * @return void
     */
    final public function addRecipesStashIngredients($reci_stash_id, $ingredients) {
        for ($i= 0; $i < count($ingredients); $i++) {
            $this->preparedAddRecipesStashIngredientsRequest->execute([$reci_stash_id, $ingredients[$i]]);
        }
    }

    /**
     * Method addRecipesIngredients
     * Method to call the prepared request to add recipe's ingredients.
     * @param string $reci_id Recipe's id
     * @param array $ingredients List of the ingredients to add
     *
     * @return void
     */
    final public function deleteStashRecipesIngredients($reci_id) {
        $this->preparedDeleteStashRecipesIngredientsRequest->execute([$reci_id]);
    }
    
}