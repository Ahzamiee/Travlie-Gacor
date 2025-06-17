<?php
class Operator extends Model {
    public function getAll() {
        $result = $this->dbconn->query("SELECT * FROM operators ORDER BY name ASC");
        $items = [];
        while ($row = $result->fetch_object()) {
            $items[] = $row;
        }
        return $items;
    }
}