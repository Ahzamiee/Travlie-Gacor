<?php
class Vehicle extends Model {

    /**
     * Mengambil semua data kendaraan untuk digunakan di dropdown form.
     * Menggabungkan dengan nama operator untuk tampilan yang lebih informatif.
     */
    public function getAll() {
        $query = "
            SELECT 
                v.id,
                v.class_name,
                v.type,
                o.name as operator_name
            FROM vehicles v
            JOIN operators o ON v.operator_id = o.id
            ORDER BY o.name ASC, v.class_name ASC
        ";
        $result = $this->dbconn->query($query);
        // Menggunakan fetch_all(MYSQLI_ASSOC) agar hasilnya berupa array asosiatif
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}