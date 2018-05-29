<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sensor
 *
 * @author cstift
 */
class Sensor extends ElectricModelItem {
    //put your code here
    public function create($parentId, $specification) {
        $sql = " INSERT INTO " . $this->tableNameString . "(".$this->parentIdTypeString.", name, unit, value) VALUES (". $parentId . " , '" . $specification->name . "', " . $specification->unit .", " . $specification->value . ")";
        return $this->database->query($sql);
    }

    public function update($itemId, $specification) {
        $sql = " UPDATE ". $this->tableNameString . " SET name = '" . $specification->name . "', unit = '" . $specification->unit . "', value = '" . $specification->value . "' WHERE id = " . $itemId . "";
        return $this->database->query($sql);
    }

}
