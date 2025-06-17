<?php
class Charter extends Model {
    public function searchCharters($vehicle_type) {
        $query = "
            SELECT 
                cs.*,
                v.class_name as vehicle_class,
                v.capacity as vehicle_capacity,
                v.type as vehicle_type,
                o.name as operator_name
            FROM charter_services cs
            JOIN vehicles v ON cs.vehicle_id = v.id
            JOIN operators o ON v.operator_id = o.id
            WHERE v.type = ?
            ORDER BY cs.base_price ASC
        ";

        $stmt = $this->dbconn->prepare($query);
        $stmt->bind_param("s", $vehicle_type);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_object()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }
}