<?php

class BusController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
          header("Location:?c=auth&m=login");
          exit();
        }
    }

    /**
     * Metode ini sekarang menjadi halaman utama untuk fitur bus.
     * URL: ?c=bus&m=index
     */
    public function index() {
      // 1. Load model yang kita butuhkan di awal
      $locationModel = $this->loadModel('Location');
      
      // 2. Siapkan sebuah array untuk menampung semua data
      $data = [];
      $data['locations'] = $locationModel->getAll();
      $data['schedules'] = [];
      $data['charters'] = [];

      // Logika untuk Form "Pesan Tiket"
      if (isset($_POST['cari_tiket'])) {
          $origin_id = $_POST['kota_keberangkatan'] ?? null;
          $destination_id = $_POST['kota_tujuan'] ?? null;
          $vehicle_type = $_POST['vehicleType'] ?? null;
          $schedule_date = $_POST['tanggal_keberangkatan'] ?? null;

          if (!empty($origin_id) && !empty($destination_id) && !empty($vehicle_type) && !empty($schedule_date)) {
              $data['schedules'] = $this->loadModel('Schedule')->searchTickets($origin_id, $destination_id, $vehicle_type, $schedule_date);
          }
      }

      // Logika untuk Form "Sewa Rombongan"
      if (isset($_POST['cari_kendaraan'])) {
          $charter_vehicle_type = $_POST['charterVehicleType'] ?? null;
          if (!empty($charter_vehicle_type)) {
              $data['charters'] = $this->loadModel('Charter')->searchCharters($charter_vehicle_type);
          }
      }
      
      // Load view bus.php dengan data yang sudah diproses
      $this->loadView('dashboard/bus', $data);
    }
}