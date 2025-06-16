<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

error_log("DEBUG: (AccommodationController.php) Step 20 - AccommodationController.php di-load."); // Tulis ke log

// TUGASLK02/controllers/AccommodationController.php
// Pastikan base Controller di-include terlebih dahulu karena ini adalah parent class
require_once __DIR__ . '/Controller.php';

// Model spesifik yang akan digunakan oleh controller ini
// require_once __DIR__ . '/../models/AccommodationModel.php'; // Ini bisa dihapus jika loadModel() sudah menangani inclusion

class AccommodationController extends Controller {
    private $accommodationModel;

    public function __construct() {
        error_log("DEBUG: (AccommodationController.php) Step 21 - Constructor dipanggil."); // Marker 21 (seharusnya ini muncul sebagai pengganti TEST success)
        
        $this->checkLogin(); // Ini akan mengarahkan ke halaman login jika belum login.

        $this->accommodationModel = $this->loadModel('AccommodationModel');
        error_log("DEBUG: (AccommodationController.php) Step 22 - Model akomodasi diinisialisasi."); // Marker 22
    }

    public function index() {
        // Check if user is admin
        $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
        
        // Get filters from GET parameters
        $filters = [
            'rating' => $_GET['rating'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
            'type' => $_GET['type'] ?? null,
            'location' => $_GET['location'] ?? null,
            'show_inactive' => ($isAdmin && isset($_GET['show_inactive'])) ? $_GET['show_inactive'] : null
        ];
        
        // Get accommodations based on filters
        if ($isAdmin && !empty($filters['show_inactive']) && $filters['show_inactive'] === '1') {
            // For admin: get all accommodations including inactive ones
            $accommodations = $this->accommodationModel->getFilteredAccommodationsWithInactive($filters);
        } else {
            // For regular users: get only active accommodations
            $accommodations = $this->accommodationModel->getFilteredAccommodations($filters);
        }
        
        $data = [
            'accommodations' => $accommodations,
            'filters' => $filters
        ];
        
        $this->loadView('accommodation/index', $data);
    }

    // Contoh metode lain: untuk melihat detail akomodasi
    // Perbaikan untuk method detail di AccommodationController

    public function detail($id = null) {
        error_log("DEBUG: detail() method called");
        
        // Ambil ID dari parameter atau $_GET
        if ($id === null && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if ($id === null) {
            error_log("DEBUG: No ID provided, redirecting to index");
            // PERBAIKAN: Jangan gunakan URL sebagai view name
            header('Location: ?c=accommodation&m=index');
            exit();
        }

        error_log("DEBUG: Getting accommodation with ID: " . $id);
        $accommodation = $this->accommodationModel->getAccommodationById($id);

        if ($accommodation) {
            error_log("DEBUG: Accommodation found, loading detail view");
            $data = ['accommodation' => $accommodation];
            
            // PERBAIKAN: Pastikan ini adalah nama view yang benar, bukan URL
            $this->loadView('accommodation/accommodation-detail', $data);
        } else {
            error_log("DEBUG: Accommodation not found, redirecting with error");
            // PERBAIKAN: Gunakan header redirect, bukan loadView dengan URL
            header('Location: ?c=accommodation&m=index&error=notfound');
            exit();
        }
    }

    // Helper method to check admin access
    private function checkAdminAccess() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?c=auth&m=login&error=access_denied');
            exit();
        }
    }

    // --- BARU: Metode pembantu untuk memeriksa apakah pengguna sudah login ---
    private function checkLogin() {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $_SESSION['error_message'] = 'Anda harus login untuk mengakses halaman ini.'; // Set pesan error
            header('Location: ?c=auth&m=login&error=not_logged_in');
            exit();
        }
    }

}
