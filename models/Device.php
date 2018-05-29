<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of devices
 *
 * @author cstift
 */
class Device extends ElectricModelItem {
    //put your code here
    public function create($parentId, $specification) {
        $sql = " INSERT INTO " . $this->tableNameString . "(".$this->parentIdTypeString.", name) VALUES (". $parentId . " , '" . $specification->name . "')";
        return $this->database->query($sql);
    }

    public function update($itemId, $specification) {
        $sql = " UPDATE ". $this->tableNameString . " SET name = '" . $specification->name . "' WHERE id = " . $itemId . "";
        return $this->database->query($sql);
    }

}
