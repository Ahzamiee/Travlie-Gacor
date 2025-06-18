<?php

// Pastikan model Flight.php di-include atau di-autoload
// Jika Anda menggunakan spl_autoload_register, pastikan path-nya benar
require_once __DIR__ . '/../models/Model.php'; // Untuk Model.php Anda
require_once __DIR__ . '/../models/Flight.php'; // Untuk Flight.php
require_once __DIR__ . '/Controller.php'; // Pastikan Controller.php juga di-load jika belum

class FlightController extends Controller {
    private $flightModel;

    // Constructor tidak perlu parameter $db lagi karena Flight model akan menangani koneksi sendiri
    public function __construct() {
        $this->flightModel = new Flight(); // Inisialisasi Flight model
    }

    public function index() {
        $flights = [];
        $dari = $_GET['dari'] ?? '';
        $ke = $_GET['ke'] ?? '';
        $tanggal_input = $_GET['tanggal'] ?? ''; // Format hh/bb/tttt

        // Konversi tanggal dari hh/bb/tttt ke YYYY-MM-DD untuk database
        $tanggal_db = '';
        if (!empty($tanggal_input)) {
            $parts = explode('/', $tanggal_input);
            if (count($parts) == 3) {
                // Asumsi hh/bb/tttt = hari/bulan/tahun
                $day = $parts[0];
                $month = $parts[1];
                $year = $parts[2];
                if (checkdate($month, $day, $year)) {
                    $tanggal_db = $year . '-' . $month . '-' . $day;
                }
            }
        }

        $dewasa = $_GET['dewasa'] ?? 1;
        $anak = $_GET['anak'] ?? 0;
        $kelas = $_GET['kelas'] ?? 'Economy';

        // Jika ada parameter pencarian (salah satu saja cukup untuk memicu pencarian)
        if (!empty($dari) || !empty($ke) || !empty($tanggal_db) || $dewasa > 0 || $anak > 0 || !empty($kelas)) {
            $flights = $this->flightModel->searchFlights($dari, $ke, $tanggal_db, $dewasa, $anak, $kelas);
        } else {
            // Tampilkan beberapa penerbangan default jika tidak ada pencarian
            $flights = $this->flightModel->getAllFlights();
        }

        // Load view
        // Pastikan path ke flight.php benar relatif dari tempat FlightController di-load
        include __DIR__ . '/../views/dashboard/flight.php';
    }

    public function getCitiesAutocomplete() {
        $searchTerm = $_GET['term'] ?? '';
        $cities = $this->flightModel->getCities($searchTerm); // Mengembalikan array

        header('Content-Type: application/json');
        echo json_encode($cities);
    }

    // Method baru untuk menampilkan detail penerbangan
    public function detail() {
        $flight = null;
        $flight_id = $_GET['id'] ?? null;

        if ($flight_id) {
            $flight = $this->flightModel->getFlightById($flight_id);
        }

        // Load view detail penerbangan
        include __DIR__ . '/../views/dashboard/flight_detail.php';
    }
}
