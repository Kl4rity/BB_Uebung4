<?php

/**
 * Description of Database
 *
 * @author helmuth
 */
class Database extends PDO{
    private $pdo;
    
    public function __construct($dbHost, $dbName, $dbUser,$dpPass){
        $this->pdo = new PDO("mysql:host=".$dbHost.";dbname=".$dbName.";charset=utf8", $dbUser, $dpPass);
    }

    public function query( $sql){        
        try{
            $queryResult = $this->pdo->query($sql)->fetchAll();
            
            if(!$queryResult){
                if(strpos($sql, "INSERT") !== false){
                    $queryResult = array(
                    "status" => "OK",
                    "newId" => $this->pdo->lastInsertId()
                   );
                } else {
                    $queryResult = array(
                    "status" => "OK"
                   );
                }
            }
        } catch (PDOException $ex){
            error_log("PDO ERROR: querying database: " . $ex->getMessage()."\n".$sql);
            $queryResult = array(
                    "status" => "NOK"
                   );
            return $queryResult;
        }
        
        return $queryResult;
    }
}