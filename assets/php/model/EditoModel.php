<?php
require_once("./assets/php/model/BaseModel.php");
class EditoModel extends BaseModel {
    private PDOStatement $preparedLastEditoRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetLastEdito();
    }
    
    /**
     * Method prepareGetLastEdito
     * Method to prepare the request to get the last edito.
     * @return void
     */
    final private function prepareGetLastEdito() {
        $getLastEditoRequest = "SELECT edi_text
        FROM ptic_edito
        ORDER BY edi_date DESC LIMIT 1";
        $this->preparedLastEditoRequest = $this->connection->prepare($getLastEditoRequest);
    }

    /**
     * Method getLastEdito
     * Method to call the prepared request to get the last edito.
     *
     * @return array
     */
    final public function getLastEdito() {
        $this->preparedLastEditoRequest->execute();
        return $this->preparedLastEditoRequest->fetchAll()[0]["edi_text"];
    }
    
}