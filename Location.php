<?php
class Location extends Model {
    public function getAll() {
        $query = "SELECT * FROM locations ORDER BY location_name ASC";
        $result = $this->dbconn->query($query);
        
        // Mengembalikan hasil sebagai array asosiatif, bukan objek.
        // Ini akan membuat formatnya konsisten dengan model lain.
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}