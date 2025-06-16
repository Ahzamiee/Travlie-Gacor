<?php
// File: controllers/AccommodationController.php

require_once __DIR__ . '/Controller.php';

class AccommodationController extends Controller {
    private $accommodationModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkLogin();
        // PERBAIKAN: Hapus loadModel dari constructor agar lebih efisien
    }

    public function index() {
        // PERBAIKAN: Load model di sini karena method ini membutuhkannya
        $this->accommodationModel = $this->loadModel('Accommodation');

        $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
        
        $filters = [
            'rating' => $_GET['rating'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            // ... filter lainnya ...
            'include_inactive' => ($isAdmin && !empty($_GET['show_inactive']))
        ];
        
        // Panggil method yang sudah disederhanakan di model
        $accommodations = $this->accommodationModel->getFilteredAccommodations($filters);
        
        $data = [
            'accommodations' => $accommodations,
            'filters' => $filters
        ];
        
        $this->loadView('accommodation/index', $data);
    }

    public function detail($id = null) {
        // PERBAIKAN: Load model di sini karena method ini membutuhkannya
        $this->accommodationModel = $this->loadModel('Accommodation');
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

    public function fetchActiveForDashboard() {
        // PERBAIKAN: Load model di sini karena method ini membutuhkannya
        $this->accommodationModel = $this->loadModel('Accommodation');
        
        $accommodations = $this->accommodationModel->getActiveForDashboard(4);

        header('Content-Type: application/json');
        echo json_encode($accommodations);
        exit();
    }

    private function checkLogin() {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $_SESSION['error_message'] = 'Anda harus login untuk mengakses halaman ini.';
            header('Location: ?c=auth&m=login&error=not_logged_in');
            exit();
        }
    }
    
    // PERBAIKAN: checkAdminAccess() bisa dihapus jika tidak ada method spesifik yang butuh akses admin
    // yang tidak diproteksi oleh constructor di AdminController.
}
