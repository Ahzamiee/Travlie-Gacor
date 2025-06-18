<?php

// Pastikan base Model.php di-include atau di-autoload
require_once 'Model.php'; // Jika Flight.php dan Model.php di folder yang sama

class Flight extends Model { // Flight sekarang meng-extend Model
    private $table_flights = 'flights';
    private $table_cities = 'cities';

    // Constructor tidak perlu parameter $db lagi karena akan menggunakan dbconn dari parent
    public function __construct() {
        parent::__construct(); // Panggil constructor parent untuk inisialisasi koneksi mysqli
        // Koneksi database sekarang tersedia via $this->dbconn dari parent class
    }

    // Fungsi untuk mendapatkan daftar kota untuk autocomplete
    public function getCities($searchTerm) {
        $searchTerm = $this->dbconn->real_escape_string($searchTerm); // Sanitize input
        $query = "SELECT name FROM " . $this->table_cities . " WHERE name LIKE '%" . $searchTerm . "%' LIMIT 10";
        $result = $this->dbconn->query($query);

        $cities = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cities[] = $row['name'];
            }
            $result->free();
        }
        return $cities;
    }

    // Fungsi untuk mencari penerbangan
    public function searchFlights($dari, $ke, $tanggal, $dewasa, $anak, $kelas) {
        // Sanitize input
        $dari = $this->dbconn->real_escape_string($dari);
        $ke = $this->dbconn->real_escape_string($ke);
        $tanggal = $this->dbconn->real_escape_string($tanggal);
        $kelas = $this->dbconn->real_escape_string($kelas);
        // $dewasa dan $anak biasanya integer, jadi tidak perlu real_escape_string
        // tetapi tetap lakukan validasi atau cast ke int jika digunakan dalam query

        $query = "SELECT * FROM " . $this->table_flights . " WHERE 1=1";

        if (!empty($dari)) {
            $query .= " AND departure_city_name LIKE '%" . $dari . "%'";
        }
        if (!empty($ke)) {
            $query .= " AND arrival_city_name LIKE '%" . $ke . "%'";
        }
        if (!empty($tanggal)) {
            // Asumsi tanggal dari input adalah YYYY-MM-DD
            $query .= " AND departure_date = '" . $tanggal . "'"; // Asumsi tanggal sudah YYYY-MM-DD
        }
        // $dewasa dan $anak tidak digunakan langsung dalam query contoh ini,
        // tetapi bisa ditambahkan jika ada kolom di tabel flights untuk kapasitas penumpang.
        if (!empty($kelas)) {
            $query .= " AND flight_class = '" . $kelas . "'";
        }

        $query .= " ORDER BY departure_date ASC";

        $result = $this->dbconn->query($query);

        $flights = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $flights[] = $row;
            }
            $result->free();
        }
        return $flights;
    }

    // Fungsi untuk mendapatkan semua penerbangan (jika tidak ada pencarian)
    public function getAllFlights() {
        $query = "SELECT * FROM " . $this->table_flights . " ORDER BY departure_date ASC LIMIT 6";
        $result = $this->dbconn->query($query);

        $flights = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $flights[] = $row;
            }
            $result->free();
        }
        return $flights;
    }

    // Method baru untuk mendapatkan detail penerbangan berdasarkan ID
    public function getFlightById($flightId) {
        // Pastikan $flightId adalah integer untuk keamanan
        $flightId = (int)$flightId;

        $query = "SELECT * FROM " . $this->table_flights . " WHERE id = " . $flightId;
        $result = $this->dbconn->query($query);

        if ($result && $result->num_rows > 0) {
            $flight = $result->fetch_assoc();
            $result->free();
            return $flight;
        }
        return null; // Mengembalikan null jika penerbangan tidak ditemukan
    }

    public function addFlight($data) {
        // Asumsi $data adalah array asosiatif dengan kunci sesuai kolom DB
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $query = "INSERT INTO " . $this->table_flights . " ($columns) VALUES ($placeholders)";

        $stmt = $this->dbconn->prepare($query);

        if (!$stmt) {
            return false; // Error prepare statement
        }

        // Tentukan tipe parameter secara dinamis
        $types = '';
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's'; // Default to string
            }
        }

        $stmt->bind_param($types, ...array_values($data));
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Metode baru untuk memperbarui penerbangan
    public function updateFlight($id, $data) {
        $setClauses = [];
        $params = [];
        $types = '';

        foreach ($data as $column => $value) {
            $setClauses[] = "$column = ?";
            $params[] = $value;
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $setClauseString = implode(", ", $setClauses);
        $query = "UPDATE " . $this->table_flights . " SET $setClauseString WHERE id = ?";

        $params[] = $id;
        $types .= 'i'; // ID is integer

        $stmt = $this->dbconn->prepare($query);

        if (!$stmt) {
            return false; // Error prepare statement
        }

        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Metode baru untuk menghapus penerbangan
    public function deleteFlight($id) {
        $query = "DELETE FROM " . $this->table_flights . " WHERE id = ?";
        $stmt = $this->dbconn->prepare($query);

        if (!$stmt) {
            return false; // Error prepare statement
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
