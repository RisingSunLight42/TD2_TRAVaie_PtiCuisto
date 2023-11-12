<?php
require_once("./assets/php/model/BaseModel.php");
class RecipesStashModel extends BaseModel {
    private PDOStatement $preparedCreateRecipeStashRequest;
    private PDOStatement $preparedGetRecipesStashByIdRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareCreateRecipeStash();
        $this->prepareGetRecipesStashById();
    }
    
    /**
     * Method prepareCreateRecipeStash
     * Method to prepare the request to create a stash recipe.
     * @return void
     */
    final private function prepareCreateRecipeStash() {
        $createRecipeStashRequest= "INSERT INTO ptic_recipes_stash(reci_stash_title, reci_stash_content, reci_stash_resume,
        rtype_id, reci_stash_creation_date, reci_stash_image, users_id, stash_type_id)
        VALUES (:title, :descr, :resume,(
            SELECT rtype_id
            FROM ptic_recipes_type
            WHERE UPPER(rtype_title) = UPPER(:cat)
        ), NOW(), :img, (
            SELECT users_id
            FROM ptic_users
            WHERE users_nickname = :user
        ), (SELECT stash_type_id FROM ptic_stash_type WHERE UPPER(stash_type_value) = 'CREATION'))";
        $this->preparedCreateRecipeStashRequest = $this->connection->prepare($createRecipeStashRequest);
    }

    /**
     * Method prepareGetRecipesStashById
     * Method to prepare the request to get stash recipe by its id.
     * @return void
     */
    final private function prepareGetRecipesStashById() {
        $getRecipesStashByIdRequest = "SELECT reci_stash_title as reci_title, rtype_title, reci_stash_image as reci_image,
        reci_stash_content as reci_content, stash_type_value,
        users_nickname, reci_stash_resume as reci_resume,
        DATE_FORMAT(reci_stash_creation_date, '%d/%m/%Y à %H:%i:%S') as reci_creation_date,
        DATE_FORMAT(reci_stash_creation_date, '%d/%m/%Y à %H:%i:%S') as reci_edit_date, reci_id
        FROM ptic_recipes_stash
        JOIN ptic_recipes_type USING (rtype_id)
        JOIN ptic_users USING (users_id)
        JOIN ptic_stash_type USING (stash_type_id)
        WHERE reci_stash_id = ?";
        $this->preparedGetRecipesStashByIdRequest = $this->connection->prepare($getRecipesStashByIdRequest);
    }

    /**
     * Method createRecipeStash
     * Method to call the prepared request to create a stash recipe.
     * @param string $title Stash Recipe's title
     * @param string $desc Stash Recipe's description
     * @param string $resume Stash Recipe's resume
     * @param string $category Stash Recipe's category
     * @param string $img Stash Recipe's image link
     * @param string $user Stash Recipe's user nickname
     *
     * @return number Inserted stash recipe's id
     */
    final public function createRecipeStash($title, $desc, $resume, $category, $img, $user) {
        $this->preparedCreateRecipeStashRequest->bindValue(':title', (string) $title, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->bindValue(':descr', (string) $desc, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->bindValue(':resume', (string) $resume, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->bindValue(':cat', (string) $category, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->bindValue(':img', (string) $img, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->bindValue(':user', (string) $user, PDO::PARAM_STR);
        $this->preparedCreateRecipeStashRequest->execute();
        return $this->connection->lastInsertId();
    }

    /**
     * Method getRecipeStashById
     * Method to call the prepared request to get the stash recipe by its id.
     *
     * @return array
     */
    final public function getRecipeStashById($reci_stash_id) {
        $this->preparedGetRecipesStashByIdRequest->execute([$reci_stash_id]);
        return $this->preparedGetRecipesStashByIdRequest->fetchAll();
    }
    
}