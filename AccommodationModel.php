<?php
// TUGASLK02/models/AccommodationModel.php

// Pastikan Model.php (base model/database) sudah di-include
require_once __DIR__ . '/Model.php'; 

class AccommodationModel extends Model { // Extends Model untuk akses DB
    public function __construct() {
        parent::__construct(); // Panggil constructor dari Model untuk inisialisasi $dbconn
        error_log("DEBUG: (AccommodationModel.php) Step 27 - AccommodationModel constructor dipanggil."); // Tulis ke log

    }

    public function getAllAccommodations($filters = []) {
        
        error_log("DEBUG: (AccommodationModel.php) Step 28 - getAllAccommodations dipanggil."); // Marker 28

        // Output debug ke log dan browser
        error_log("DEBUG: (AccommodationModel.php) SQL building started.");
        error_log("DEBUG: (AccommodationModel.php) Filters received: " . json_encode($filters));

        // PERHATIAN: Pilih kolom yang benar-benar Anda butuhkan saja untuk halaman daftar.
        // Ini menghindari pengambilan data besar (seperti TEXT/LONGTEXT) yang tidak perlu.
        $sql = "SELECT 
                    id_akomodasi,
                    nama_akomodasi,
                    rating_bintang,
                    jumlah_ulasan,
                    kota,
                    harga_standard,
                    harga_diskon,
                    url_gambar_utama
                FROM 
                    accommodations 
                WHERE 
                    is_aktif = 1"; 
        
        $params = []; // Array untuk parameter prepared statement
        $types = '';  // String untuk tipe parameter (s, i, d, dll.)

        // Filter berdasarkan Rating
        if (isset($filters['rating']) && is_numeric($filters['rating'])) {
            $sql .= " AND rating_bintang >= ?"; // Rating minimal
            $params[] = (int)$filters['rating'];
            $types .= 'i';
        }

        // Filter berdasarkan Harga Minimum
        if (isset($filters['price_min']) && is_numeric($filters['price_min'])) {
            $sql .= " AND (harga_diskon >= ? OR (harga_diskon IS NULL AND harga_standard >= ?))";
            $params[] = (float)$filters['price_min'];
            $params[] = (float)$filters['price_min']; // Perlu dua kali untuk OR
            $types .= 'dd'; // Dua kali double (float)
        }

        // Filter berdasarkan Harga Maksimum
        if (isset($filters['price_max']) && is_numeric($filters['price_max'])) {
            $sql .= " AND (harga_diskon <= ? OR (harga_diskon IS NULL AND harga_standard <= ?))";
            $params[] = (float)$filters['price_max'];
            $params[] = (float)$filters['price_max']; // Perlu dua kali untuk OR
            $types .= 'dd'; // Dua kali double (float)
        }

        // Filter berdasarkan Tipe Akomodasi
        if (isset($filters['type']) && is_array($filters['type']) && !empty($filters['type'])) {
            $placeholders = implode(',', array_fill(0, count($filters['type']), '?'));
            $sql .= " AND tipe_akomodasi IN ($placeholders)";
            foreach ($filters['type'] as $type) {
                $params[] = $type;
                $types .= 's'; // String
            }
        }
        
        $sql .= " ORDER BY rating_bintang DESC"; // Urutkan hasil

        error_log("DEBUG: (AccommodationModel.php) Final SQL: " . $sql);
        error_log("DEBUG: (AccommodationModel.php) Final Params: " . json_encode($params));
        error_log("DEBUG: (AccommodationModel.php) Final Types: " . $types);
        
        $stmt = $this->dbconn->prepare($sql);

        if ($stmt === false) {
            error_log("FATAL ERROR: (AccommodationModel.php) Prepare failed: (" . $this->dbconn->errno . ") " . $this->dbconn->error);
            // die("Error Fatal: Database Prepare Gagal. Cek log error PHP."); 
            return [];
        }

        if (!empty($params)) {
            $bind_result = call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $this->refValues($params)));
            if ($bind_result === false) {
                 error_log("FATAL ERROR: (AccommodationModel.php) Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
                 return [];
            }
        }
        
        $execute_result = $stmt->execute();
        if ($execute_result === false) {
            error_log("FATAL ERROR: (AccommodationModel.php) Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return[];
        }

        $result = $stmt->get_result();
        if ($result === false) {
            error_log("FATAL ERROR: (AccommodationModel.php) Get result failed: (" . $this->dbconn->errno . ") " . $this->dbconn->error);
            return[];
        }
        
        // --- KEMBALI KE fetch_object() LOOP DENGAN PERBAIKAN ---
        $accommodations = [];
        // Pastikan loop berjalan dan data dimasukkan ke array
        while ($row = $result->fetch_object()) {
            $accommodations[] = $row;
        }
        
        // Bebaskan result set SETELAH SEMUA DATA DIAMBIL
        $result->free(); 
        // Tutup statement SETELAH SEMUA DATA DIAMBIL DAN RESULT DIBEBASKAN
        $stmt->close();  

        // --- PERBAIKAN SELESAI ---

        error_log("DEBUG: (AccommodationModel.php) Number of rows returned by DB: " . count($accommodations)); // Gunakan count($accommodations)
        error_log("DEBUG: (AccommodationModel.php) Final Accommodations array count: " . count($accommodations));
        
        return $accommodations;
    }

    private function refValues($arr) {
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = [];
            foreach ($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }


    public function getAccommodationById($id) {
        // Untuk halaman detail, Anda mungkin memerlukan lebih banyak kolom
        $stmt = $this->dbconn->prepare("SELECT 
                                            id_akomodasi,
                                            nama_akomodasi,
                                            deskripsi_singkat,
                                            deskripsi_lengkap,
                                            tipe_akomodasi,
                                            provinsi,
                                            kota,
                                            rating_bintang,
                                            skor_ulasan_rata,
                                            jumlah_ulasan,
                                            harga_standard,
                                            harga_diskon,
                                            kapasitas_default_tamu,
                                            check_in_standar,
                                            check_out_standar,
                                            telepon_kontak,
                                            email_kontak,
                                            website_url,
                                            url_gambar_utama,
                                            list_url_gambar,
                                            list_fasilitas,
                                            list_tipe_kamar_dasar
                                        FROM 
                                            accommodations 
                                        WHERE 
                                            id_akomodasi = ? AND is_aktif = 1");
        
        $stmt->bind_param("i", $id); 
        $stmt->execute();

        $result = $stmt->get_result();
        $accommodation = $result->fetch_object(); 

        $stmt->close(); 
        return $accommodation;
    }

    public function getAllAccommodationsForAdmin() {
        $sql = "SELECT 
                    id_akomodasi,
                    nama_akomodasi,
                    tipe_akomodasi,
                    kota,
                    rating_bintang,
                    harga_standard,
                    harga_diskon,
                    is_aktif,
                    created_at
                FROM 
                    accommodations 
                ORDER BY 
                    created_at DESC";
        
        $result = $this->dbconn->query($sql);
        
        $accommodations = [];
        while ($row = $result->fetch_object()) {
            $accommodations[] = $row;
        }
        
        return $accommodations;
    }

    public function getTotalAccommodations() {
        $result = $this->dbconn->query("SELECT COUNT(*) as total FROM accommodations WHERE is_aktif = 1");
        $row = $result->fetch_object();
        return $row->total;
    }

    public function getRecentAccommodations($limit = 5) {
        $stmt = $this->dbconn->prepare("SELECT 
                                            id_akomodasi,
                                            nama_akomodasi,
                                            kota,
                                            created_at
                                        FROM 
                                            accommodations 
                                        WHERE 
                                            is_aktif = 1 
                                        ORDER BY 
                                            created_at DESC 
                                        LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $accommodations = [];
        while ($row = $result->fetch_object()) {
            $accommodations[] = $row;
        }
        
        $stmt->close();
        return $accommodations;
    }

    public function createAccommodation($data) {
        $sql = "INSERT INTO accommodations (
                    nama_akomodasi, deskripsi_singkat, deskripsi_lengkap, 
                    tipe_akomodasi, provinsi, kota, rating_bintang, 
                    harga_standard, harga_diskon, url_gambar_utama, 
                    telepon_kontak, email_kontak, is_aktif
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ssssssiddsss", 
            $data['nama_akomodasi'],
            $data['deskripsi_singkat'],
            $data['deskripsi_lengkap'],
            $data['tipe_akomodasi'],
            $data['provinsi'],
            $data['kota'],
            $data['rating_bintang'],
            $data['harga_standard'],
            $data['harga_diskon'],
            $data['url_gambar_utama'],
            $data['telepon_kontak'],
            $data['email_kontak']
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    public function updateAccommodation($id, $data) {
        $sql = "UPDATE accommodations SET 
                    nama_akomodasi = ?, deskripsi_singkat = ?, deskripsi_lengkap = ?, 
                    tipe_akomodasi = ?, provinsi = ?, kota = ?, rating_bintang = ?, 
                    harga_standard = ?, harga_diskon = ?, url_gambar_utama = ?, 
                    telepon_kontak = ?, email_kontak = ?
                WHERE id_akomodasi = ?";
        
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ssssssdddsssi", 
            $data['nama_akomodasi'],
            $data['deskripsi_singkat'],
            $data['deskripsi_lengkap'],
            $data['tipe_akomodasi'],
            $data['provinsi'],
            $data['kota'],
            $data['rating_bintang'],
            $data['harga_standard'],
            $data['harga_diskon'],
            $data['url_gambar_utama'],
            $data['telepon_kontak'],
            $data['email_kontak'],
            $id
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    public function deleteAccommodation($id) {
        // Soft delete - ubah is_aktif menjadi 0
        $stmt = $this->dbconn->prepare("UPDATE accommodations SET is_aktif = 0 WHERE id_akomodasi = ?");
        $stmt->bind_param("i", $id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    public function toggleAccommodationStatus($id) {
        $stmt = $this->dbconn->prepare("UPDATE accommodations SET is_aktif = NOT is_aktif WHERE id_akomodasi = ?");
        if ($stmt === false) {
            error_log("ERROR: AccommodationModel->toggleAccommodationStatus prepare failed: " . $this->dbconn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        
        $result = $stmt->execute();
        if ($result === false) {
            error_log("ERROR: AccommodationModel->toggleAccommodationStatus execute failed: " . $stmt->error);
        }
        $stmt->close();
        
        return $result;
    }

    public function getFilteredAccommodations($filters = []) {
    $sql = "SELECT * FROM accommodations WHERE is_aktif = 1";
    $params = [];
    $types = "";
    
    // Add filters
    if (!empty($filters['rating'])) {
        $sql .= " AND rating_bintang >= ?";
        $params[] = $filters['rating'];
        $types .= "i";
    }
    
    if (!empty($filters['price_min'])) {
        $sql .= " AND (COALESCE(harga_diskon, harga_standard) >= ?)";
        $params[] = str_replace(['.', ','], '', $filters['price_min']);
        $types .= "d";
    }
    
    if (!empty($filters['price_max'])) {
        $sql .= " AND (COALESCE(harga_diskon, harga_standard) <= ?)";
        $params[] = str_replace(['.', ','], '', $filters['price_max']);
        $types .= "d";
    }
    
    if (!empty($filters['type']) && is_array($filters['type'])) {
        $placeholders = str_repeat('?,', count($filters['type']) - 1) . '?';
        $sql .= " AND tipe_akomodasi IN ($placeholders)";
        foreach ($filters['type'] as $type) {
            $params[] = $type;
            $types .= "s";
        }
    }
    
    if (!empty($filters['location'])) {
        $sql .= " AND (kota LIKE ? OR provinsi LIKE ?)";
        $params[] = '%' . $filters['location'] . '%';
        $params[] = '%' . $filters['location'] . '%';
        $types .= "ss";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if (empty($params)) {
        $result = $this->dbconn->query($sql);
    } else {
        $stmt = $this->dbconn->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $accommodations = [];
    while ($row = $result->fetch_object()) {
        $accommodations[] = $row;
    }
    
    if (isset($stmt)) {
        $stmt->close();
    }
    
    return $accommodations;
}

public function getFilteredAccommodationsWithInactive($filters = []) {
    $sql = "SELECT * FROM accommodations WHERE 1=1";
    $params = [];
    $types = "";
    
    // Add filters (similar to above but without is_aktif = 1 restriction)
    if (!empty($filters['rating'])) {
        $sql .= " AND rating_bintang >= ?";
        $params[] = $filters['rating'];
        $types .= "i";
    }
    
    if (!empty($filters['price_min'])) {
        $sql .= " AND (COALESCE(harga_diskon, harga_standard) >= ?)";
        $params[] = str_replace(['.', ','], '', $filters['price_min']);
        $types .= "d";
    }
    
    if (!empty($filters['price_max'])) {
        $sql .= " AND (COALESCE(harga_diskon, harga_standard) <= ?)";
        $params[] = str_replace(['.', ','], '', $filters['price_max']);
        $types .= "d";
    }
    
    if (!empty($filters['type']) && is_array($filters['type'])) {
        $placeholders = str_repeat('?,', count($filters['type']) - 1) . '?';
        $sql .= " AND tipe_akomodasi IN ($placeholders)";
        foreach ($filters['type'] as $type) {
            $params[] = $type;
            $types .= "s";
        }
    }
    
    if (!empty($filters['location'])) {
        $sql .= " AND (kota LIKE ? OR provinsi LIKE ?)";
        $params[] = '%' . $filters['location'] . '%';
        $params[] = '%' . $filters['location'] . '%';
        $types .= "ss";
    }

    if (empty($filters['show_inactive'])) {
        $sql .= " AND is_aktif = 1";
    }

    
    $sql .= " ORDER BY is_aktif DESC, created_at DESC";
    
    if (empty($params)) {
        $result = $this->dbconn->query($sql);
    } else {
        $stmt = $this->dbconn->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $accommodations = [];
    while ($row = $result->fetch_object()) {
        $accommodations[] = $row;
    }
    
    if (isset($stmt)) {
        $stmt->close();
    }
    
    return $accommodations;
}

    // ... metode lain jika ada (create, update, delete)
}
