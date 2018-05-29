<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Project
 *
 * @author cstift
 */
class Project extends ElectricModelItem {
    //put your code here
    public function create($parentId, $specification) {
        $sql = " INSERT INTO " . $this->tableNameString . "('name') VALUES ('" . $specification->name . "')";
        return $this->database->query($sql);
    }

    public function update($itemId, $specification) {
        $sql = " UPDATE ". $this->tableNameString . " SET name = '" . $specification->name . "' WHERE id = " . $itemId . "";
        return $this->database->query($sql);
    }

}
