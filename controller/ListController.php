<?php
/**
 * @author helmuth
 */

class ListController {
   
    private $jsonView;
   
    public function __construct() {
        $this->jsonView = new JsonView();
    }
    
    public function route(){                
        $postData = json_decode(filter_input(INPUT_POST, 'data'));
        $postData = $this->validatePostData($postData);
        $responsibleModelInstance = $this->fetchResponsibleModelInstance($postData->listtype);
        $dbResponseData = $responsibleModelInstance->executeRequest($postData);
        $this->formatAndDisplayData($dbResponseData);
    }
    
    private function formatAndDisplayData($dbResponseData){
        $this->jsonView->streamOutput($dbResponseData);
    }
    
    private function validatePostData($postData){
       $validTables = 
                [
                    "PROJECTS"
                    ,"FLOORS"
                    ,"ROOMS"
                    ,"LOADERS"
                    ,"SENSORS"
                ];
       
       $validActions =
                [
                    "GETLIST"
                    , "CREATE"
                    , "UPDATE"
                    , "DELETE"
                ];
        
       $postDataIsValid = false;
       $listTypeIsValid = in_array(strtoupper($postData->listtype), $validTables);
       $actionIsValid = in_array(strtoupper($postData->action), $validActions);
       
       if(!$actionIsValid || !$listTypeIsValid){
           $postData->listtype = "ERROR";
       }
       
       return $postData;
    }
    
    private function fetchResponsibleModelInstance($listtype){
        switch(strtoupper($listtype)):
            case "PROJECTS":
                echo("Projects");
                return new Project("projects", "NONE","floors");
            case "FLOORS":
                echo("Floors");
                return new Floor("floors","projects_id", "rooms");
            case "ROOMS":
                echo("Rooms");
                return new Room("rooms", "floors_id", "devices");
            case "LAODERS":
                echo("Loaders");
                return new Device("devices", "rooms_id", "sensors");
            case "SENSORS":
                echo("Sensors");
                return new Sensor("sensors","devices_id", "NONE");
            case "ERROR":
                echo("Uh-oh, what happened? We encountered an error with the operation you are trying to execute or the table you are trying to execute it on.");
                break;
            default:
                echo("No known listtype was provided!");
                break;
        endswitch;
        
    }    
}
