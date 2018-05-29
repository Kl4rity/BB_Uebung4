<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ElectricModelItem
 *
 * @author cstift
 */
abstract class ElectricModelItem implements iPostRequestExecutor {
    
    protected $tableNameString;
    protected $parentIdTypeString;
    protected $database;
    protected $parentList;
    protected $childList;
    
    public function __construct($tableTypeString, $parentIdTypeString, $childList){
        $this->tableNameString = $tableTypeString;
        $this->parentIdTypeString = $parentIdTypeString;
        $this->childList = $childList;
        $this->database = new Database(DBHost, DBName, DBUser, DBPass);
    }
    
    public function executeRequest($requestData) {                
        switch(strtoupper($requestData->action)):
            case "GETLIST":
                $responseData = $this->buildContextInformationObject($this->getList($requestData->parentid));
                break;
            case "CREATE":
                $responseData = $this->create($requestData->parentid, $requestData->specification);
                break;
            case "UPDATE":
                $responseData = $this->update($requestData->itemid, $requestData->specification);
                break;
            case "DELETE":
                $responseData = $this->delete($requestData->itemid);
                break;
            default:
                $responseData = array(
                    "status" => "NOK",
                    "reason" => "List-object could not match request."
                );
                break;
        endswitch;
        
        return $responseData;
    }
    
    protected function getList($parentId) {
        $sql = " SELECT * FROM " . $this->tableNameString . " WHERE " . $this->parentIdTypeString ." = " . $parentId . " ";
        return $this->database->query($sql);
    }
    
    protected function delete($itemId){
        $sql = " DELETE FROM ". $this->tableNameString . " WHERE id = " . $itemId . " LIMIT 1 ";
        return $this->database->query($sql);
    }
    
    abstract function create($parentId, $specification);
    
    abstract function update($itemId, $specification);
    
    protected function buildContextInformationObject($responseData){
        $responseObject = array (
            "currentLevel" => $this->tableNameString,
            "nextLevel" => $this->childList,
            "queryData" => $responseData
            );
        
        return $responseObject;
    }
}
