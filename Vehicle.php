<?php
require_once 'Model.php'; 

class Vehicle extends Model {
    public function getAll($isAdmin = false) {
        $conn = $this->getConnection();
        $query = "SELECT id_vehicle, jenis_kendaraan, merk, detail_kendaraan, kota, harga_per_hari, gambar_url, is_aktif FROM vehicle";

        if (!$isAdmin) {
            $query .= " WHERE is_aktif = 1"; // User biasa hanya lihat yang aktif
        }

        $query .= " ORDER BY id_vehicle DESC";
        
        $result = mysqli_query($conn, $query);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function getFilteredVehicles($kota, $tanggalMulai, $waktuMulai, $tanggalSelesai, $waktuSelesai) {
    $conn = $this->getConnection();

    $query = "SELECT id_vehicle, jenis_kendaraan, merk, detail_kendaraan, kota, harga_per_hari, gambar_url, is_aktif FROM vehicle WHERE kota = ? AND is_aktif = 1"; 
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $kota); // 's' untuk string (kota)
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $data;
    }

    public function getById($id) {
        $conn = $this->getConnection();
        $query = "SELECT id_vehicle, jenis_kendaraan, merk, detail_kendaraan, kota, harga_per_hari, gambar_url, is_aktif FROM vehicle WHERE id_vehicle = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id); // 'i' for integer (id_vehicle)
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $vehicle = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $vehicle;
    }

    public function create($data) {
        $conn = $this->getConnection();
        $query = "INSERT INTO vehicle (jenis_kendaraan, merk, detail_kendaraan, kota, harga_per_hari, gambar_url, is_aktif) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssds", 
            $data['jenis_kendaraan'], 
            $data['merk'], 
            $data['detail_kendaraan'], 
            $data['kota'], 
            $data['harga_per_hari'], 
            $data['gambar_url'],
            $data['is_aktif']
        );

        return mysqli_stmt_execute($stmt);
    }

    public function update($id, $data) {
        $conn = $this->getConnection();
        $query = "UPDATE vehicle SET jenis_kendaraan = ?, merk = ?, detail_kendaraan = ?, kota = ?, harga_per_hari = ?, gambar_url = ?, is_aktif = ? WHERE id_vehicle = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssdsi", 
            $data['jenis_kendaraan'], 
            $data['merk'], 
            $data['detail_kendaraan'], 
            $data['kota'], 
            $data['harga_per_hari'], 
            $data['gambar_url'],
            $data['is_aktif'],
            $id
        );

        return mysqli_stmt_execute($stmt);
    }

    public function toggleStatus($id) {
        $conn = $this->getConnection();
        $query = "UPDATE vehicle SET is_aktif = NOT is_aktif WHERE id_vehicle = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }

    public function delete($id) {
        $conn = $this->getConnection();
        $query = "DELETE FROM vehicle WHERE id_vehicle = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }
}
