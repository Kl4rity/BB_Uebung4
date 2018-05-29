<?php

/**
 * Description of Floor
 *
 * @author cstift
 */
class Floor extends ElectricModelItem {

    public function create($parentId, $specification) {
        $sql = " INSERT INTO " . $this->tableNameString . " (".$this->parentIdTypeString.", floor_count_from_basement, name) VALUES (". $parentId . " , " . $specification->floor_count_from_basement . " , '" . $specification->name . "')";
        return $this->database->query($sql);
    }

    public function update($itemId, $specification) {
        $sql = " UPDATE ". $this->tableNameString . " SET floor_count_from_basement = ". $specification->floor_count_from_basement . " , name = '" . $specification->name . "' WHERE id = " . $itemId . "";
        return $this->database->query($sql);
    }
}
