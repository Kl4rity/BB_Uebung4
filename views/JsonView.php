<?php

class JsonView {

    public function __construct() {
        header('Content-Type: application/json');
    }
    
    public function streamOutput($data){
        $jsonOutput = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        echo $jsonOutput;
    }
}
