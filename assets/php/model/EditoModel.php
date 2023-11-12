<?php
require_once("./assets/php/model/BaseModel.php");
class EditoModel extends BaseModel {
    private PDOStatement $preparedLastEditoRequest;
    private PDOStatement $preparedAddEditoRequest;

    public function __construct($isAdmin, $connection = null) {
        parent::__construct($isAdmin, $connection);
        $this->prepareGetLastEdito();
        $this->prepareAddEdito();
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
     * Method prepareAddEdito
     * Method to prepare the request to add a new edito.
     * @return void
     */
    final private function prepareAddEdito() {
        $addEditoRequest = "INSERT INTO ptic_edito (edi_text, edi_date) VALUES (?, NOW())";
        $this->preparedAddEditoRequest = $this->connection->prepare($addEditoRequest);
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
    
    /**
     * Method addEdito
     * Method to call the prepared request to add a new edito.
     * @param string $edito The edito to add
     *
     * @return void
     */
    final public function addEdito($edito) {
        $this->preparedAddEditoRequest->execute([$edito]);
    }
    
}