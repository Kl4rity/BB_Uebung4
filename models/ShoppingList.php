<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShoppingList
 *
 * @author cstift
 */
class ShoppingList implements iPostRequestExecutor {
    
    private $database;
    
    public function __construct(){
        $this->database = new Database(DBHost, DBName, DBUser, DBPass);
    }
    
    public function executeRequest($requestData) {
        $devices = $this->getDevices($requestData->parentid);
        $sensors = $this->getSensors($requestData->parentid);
        $projectName = $this->getProjectName($requestData->parentid);
        return $this->buildResponseArray($devices, $sensors, $projectName);
    }
    
    private function getDevices($projectId) {
        $sql = "SELECT * FROM `devices` WHERE rooms_id IN (SELECT id FROM floors WHERE projects_id = ". $projectId .");";
        return $this->database->query($sql);
    }
    
    private function getSensors($projectId) {
        $sql = "SELECT * FROM `sensors` WHERE devices_id IN (SELECT id FROM rooms WHERE floors_id IN (SELECT id FROM floors WHERE projects_id = ". $projectId ."));";
        return $this->database->query($sql);  
    }
    
    private function getProjectName($projectId){
        $sql = "SELECT name FROM projects WHERE id = ". $projectId .";";
        return $this->database->query($sql);
    }
    
    private function buildResponseArray($devices, $sensors, $projectName){
        echo("DEVICES\n");
        var_dump($devices);
        echo("SENSORS\n");
        var_dump($sensors);
        echo("PROJEKTNAME\n");
        var_dump($projectName);
        
        $response = array("project" => $projectName);
        $rawOutputList = $this->assignSensorsToDevices($devices, $sensors);
        $response["shoppinglist"] = $this->setNumberOfSameShoppingItems($rawOutputList);
        
        return $response;
    }

    
    private function assignSensorsToDevices($devices, $sensors){
        $devicesWithSensors = array();
        
        foreach($devices as $device){
            $deviceWithSensor = array("devicename" => $device["name"]);
            $sensorList = array();
            foreach($sensors as $sensor){
                if($device["id"] == $sensor["devices_id"]){
                    $sensorEntry = array(
                        "name" => $sensor["name"],
                        "unit" => $sensor["unit"]
                    );
                    $sensorList[] = $sensorEntry;
                }
            }
            $deviceWithSensor["count"] = 1;
            $deviceWithSensor["sensors"] = $sensorList;
            
            $devicesWithSensors[] = $deviceWithSensor;
        }
        return $devicesWithSensors;
    }
    
    private function setNumberOfSameShoppingItems($devicesWithSensors){
        foreach($devicesWithSensors as $entryToBeCompared){
            foreach($devicesWithSensors as $comparedToEntry){
                if(empty(array_diff($entryToBeCompared, $comparedToEntry))){
                    $devicesWithSensors[$entryToBeCompared]["count"] += 1;
                    unset($devicesWithSensors[$comparedToEntry]);
                };
            }
        }
        return $devicesWithSensors;
    }
}