<?php
require_once("./assets/php/model/BaseModel.php");
class UsersModel extends BaseModel {
    private PDOStatement $preparedGetConnectionCredentialsRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetConnectionCredentials();
    }
    
    /**
     * Method prepareGetConnectionCredentials
     * Method to prepare the request to get the user's credentials.
     * @return void
     */
    final private function prepareGetConnectionCredentials() {
        $getConnectionCredentialsRequest = "SELECT users_nickname, users_password, utype_title
        FROM ptic_users JOIN ptic_users_type USING (utype_id) WHERE users_nickname = ?";
        $this->preparedGetConnectionCredentialsRequest = $this->connection->prepare($getConnectionCredentialsRequest);
    }

    /**
     * Method getConnectionCredentials
     * Method to call the prepared request to get the user's credentials.
     *
     * @return array
     */
    final public function getConnectionCredentials($username) {
        $this->preparedGetConnectionCredentialsRequest->execute([$username]);
        return $this->preparedGetConnectionCredentialsRequest->fetchAll();
    }
    
}