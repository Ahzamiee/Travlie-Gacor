<?php
// File: controllers/DashboardController.php

class DashboardController extends Controller {

    /**
     * Konstruktor ini memastikan semua method di bawahnya
     * hanya bisa diakses oleh pengguna yang sudah login.
     */
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
     * Menampilkan halaman dashboard utama setelah login.
     */
    public function index() {
        $this->loadView("dashboard/dashboard", [
            'title' => 'Dashboard',
            'user' => $_SESSION['user']
        ]);
    }

    /**
     * Menampilkan halaman profil PENGGUNA YANG SEDANG LOGIN.
     */
    public function profile() {
        $this->loadView('dashboard/profil');
    }

    /**
     * Menampilkan form untuk MENGEDIT PROFIL DIRI SENDIRI.
     */
    public function editSelf() {
        // Data user diambil langsung dari session, tidak perlu ke database lagi
        $this->loadView("dashboard/edit_akun", [
            'user' => $_SESSION['user']
        ]);
    }

    /**
     * Memproses update PROFIL DIRI SENDIRI.
     */
    public function updateSelf() {
        // Pastikan user masih login
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }

        $userId = $_SESSION['user']['user_id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $photoFilename = $_SESSION['user']['photo'] ?? null; // Default ke foto lama

        // --- Logika Upload Foto ---
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Hapus foto lama untuk menghindari penumpukan file
            foreach (glob($uploadDir . "user_{$userId}_*") as $oldFile) {
                unlink($oldFile);
            }

            // Buat nama file baru yang unik
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photoFilename = "user_{$userId}_" . time() . "." . $ext;
            $destination = $uploadDir . $photoFilename;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                // Handle error jika upload gagal
                $this->loadView("dashboard/profile", ['error' => 'Gagal menyimpan foto.']);
                return;
            }
        }
     
        $userModel = $this->loadModel("User");
        $updateSuccess = $userModel->updateAccount($userId, $fullname, $email, $photoFilename);

        if ($updateSuccess) {
        
            $_SESSION['user']['fullname'] = $fullname;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['photo'] = $photoFilename;

            header("Location:?c=dashboard&m=profile"); 
            exit();
        } else {
            $this->loadView("dashboard/profile", ['error' => 'Gagal memperbarui data di database.']);
        }
    }
    public function accomodation() {
        $this->loadView('dashboard/accomodation');
    }
    public function promo() {
        $this->loadView('dashboard/promo');
    }
    public function vehicle() {
        $this->loadView('dashboard/vehicle');
    }
}
