<?php
class VehicleController extends Controller {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }
    }

    public function index() {
        $vehicleModel = $this->loadModel("Vehicle");
        $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
        $vehicles = $vehicleModel->getAll();

        $this->loadView("vehicle/index", [
        'title' => 'Daftar Kendaraan',
        'vehicles' => $vehicles
        ]);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location:?c=vehicle&m=index");
            exit();
    }

        $vehicleModel = $this->loadModel("Vehicle");
        $vehicle = $vehicleModel->getById($id);

        if (!$vehicle) {
        $this->loadView("vehicle/not_found", ['title' => 'Kendaraan Tidak Ditemukan']);
        header("Location: ?c=vehicle&m=index");
        return;
    }

        $this->loadView("vehicle/detail", [
        'title' => 'Detail Kendaraan',
        'vehicle' => $vehicle
        ]);
    }

    public function rent() {
        $vehicleModel = $this->loadModel("Vehicle");
        $isAdmin = isset($_SESSION['user'], $_SESSION['user']['role']) && strtolower(trim($_SESSION['user']['role'])) === 'admin';
        $vehicles = $vehicleModel->getAll($isAdmin);

        $this->loadView("vehicle/rent", [
        'title' => 'Sewa Kendaraan',
        'vehicles' => $vehicles,
        'isAdmin'=> $isAdmin
        ]);
    }

    public function filterVehicles(){
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents("php://input"), true);
            if (!is_array($input)) {
            // Log error untuk debugging
            error_log("Invalid JSON input received: " . print_r($input, true));
            throw new Exception("Invalid JSON input or empty request body.");
            }

            $kota = $input['kota'] ?? '';
            $tanggalMulai = $input['tanggalMulai'] ?? '';
            $waktuMulai = $input['waktuMulai'] ?? '';
            $tanggalSelesai = $input['tanggalSelesai'] ?? '';
            $waktuSelesai = $input['waktuSelesai'] ?? '';

            if (empty($kota) || empty($tanggalMulai) || empty($waktuMulai) || empty($tanggalSelesai) || empty($waktuSelesai)) {
                // Mengembalikan array kosong dan pesan error jika filter tidak lengkap
                echo json_encode(["error" => "Semua filter wajib diisi", "data" => []]);
                exit(); 
            }

            $vehicleModel = $this->loadModel("Vehicle");
            $vehicles = $vehicleModel->getFilteredVehicles(
                $kota,
                $tanggalMulai,
                $waktuMulai,
                $tanggalSelesai,
                $waktuSelesai
            );

            echo json_encode($vehicles); 
            exit(); 

        } catch (Exception $e) {
            error_log("Error in filterVehicles: " . $e->getMessage());
            // Mengembalikan array kosong dengan pesan error
            echo json_encode(["error" => $e->getMessage(), "data" => []]);
            exit(); 
        }
    }

    public function sewa() {
        // ambil data dari URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?c=vehicle&m=rent");
            exit();
        }
        
        $filterData = [
            'kota' => $_GET['kota'] ?? '',
            'tanggalMulai' => $_GET['tanggalMulai'] ?? '',
            'waktuMulai' => $_GET['waktuMulai'] ?? '',
            'tanggalSelesai' => $_GET['tanggalSelesai'] ?? '',
            'waktuSelesai' => $_GET['waktuSelesai'] ?? ''
        ];

        // Ambil detail kendaraan dari Model
        $vehicleModel = $this->loadModel("Vehicle");
        $vehicle = $vehicleModel->getById($id);
        if (!$vehicle) {
            $this->loadView("vehicle/not_found", ['title' => 'Kendaraan Tidak Ditemukan']);
            return;
        }
        
        // Hitung durasi dan total harga (HANYA SEKALI)
        $tanggalMulai = new DateTime($filterData['tanggalMulai']);
        $tanggalSelesai = new DateTime($filterData['tanggalSelesai']);
        $interval = $tanggalMulai->diff($tanggalSelesai);
        $durasiHari = ($interval->days == 0) ? 1 : $interval->days; // Jika 0 hari, hitung 1 hari
        $hargaPerHari = (float)$vehicle['harga_per_hari'];
        $hargaTotal = $durasiHari * $hargaPerHari;

        // Parsing jumlah kursi
        $detailKendaraan = $vehicle['detail_kendaraan'];
        $jumlahKursi = '-';
        if (preg_match('/(\d+)\s*Kursi/i', $detailKendaraan, $matches)) {
            $jumlahKursi = $matches[1];
        }
        
        // Format tanggal menggunakan private function
        $tanggalMulaiFormatted = $this->formatTanggalIndonesia($filterData['tanggalMulai']);
        $tanggalSelesaiFormatted = $this->formatTanggalIndonesia($filterData['tanggalSelesai']);

        // semua data yang akan dikirim ke View dalam satu array
        $viewData = [
            'title' => 'Sewa ' . htmlspecialchars($vehicle['merk']),
            'vehicle' => $vehicle,
            'filterData' => $filterData,
            'durasiHari' => $durasiHari,
            'hargaTotal' => $hargaTotal,
            'jumlahKursi' => $jumlahKursi,
            'tanggalMulaiFormatted' => $tanggalMulaiFormatted,
            'tanggalSelesaiFormatted' => $tanggalSelesaiFormatted
        ];
    
        // Kirim array data yang sudah lengkap ke View
        $this->loadView("vehicle/sewa", $viewData);
    }

    private function formatTanggalIndonesia($stringTanggal) {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        try {
            $date = new DateTime($stringTanggal);
            $namaHari = $hari[$date->format('w')];
            $namaBulan = $bulan[(int)$date->format('n')];
            return $namaHari . ', ' . $date->format('d') . ' ' . $namaBulan . ' ' . $date->format('Y');
        } catch (Exception $e) {
            return 'Tanggal tidak valid';
        }
    }
    
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?c=vehicle&m=rent"); // Alihkan jika bukan admin
            exit();
        }
    }

    public function toggleStatus() {
    $this->checkAdmin(); //hanya admin yang bisa akses
    $id = $_GET['id'] ?? null;

    if ($id) {
        $vehicleModel = $this->loadModel('Vehicle');
        if ($vehicleModel->toggleStatus($id)) {
            $_SESSION['message'] = "Status kendaraan berhasil diubah!";
        } else {
            $_SESSION['message'] = "Gagal mengubah status.";
        }
    }
    header("Location: ?c=vehicle&m=rent");
    exit();
    }

    public function create() {
        $this->checkAdmin();
        $this->loadView('admin/create', ['title' => 'Tambah Kendaraan Baru']);
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehicleModel = $this->loadModel('Vehicle');
            if ($vehicleModel->create($_POST)) {
                $_SESSION['message'] = "Data kendaraan berhasil ditambahkan!";
            } else {
                $_SESSION['message'] = "Gagal menambahkan data.";
            }
            header("Location: ?c=vehicle&m=rent");
            exit();
        }
    }

    public function edit() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?c=vehicle&m=rent");
            exit();
        }

        $vehicleModel = $this->loadModel('Vehicle');
        $vehicle = $vehicleModel->getById($id);

        $this->loadView('admin/edit', [
            'title' => 'Edit Kendaraan',
            'vehicle' => $vehicle
        ]);
    }

    public function update() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_vehicle'];
            $vehicleModel = $this->loadModel('Vehicle');
            if ($vehicleModel->update($id, $_POST)) {
                $_SESSION['message'] = "Data kendaraan berhasil diperbarui!";
            } else {
                $_SESSION['message'] = "Gagal memperbarui data.";
            }
            header("Location: ?c=vehicle&m=rent");
            exit();
        }
    }

    public function destroy() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $vehicleModel = $this->loadModel('Vehicle');
            if ($vehicleModel->delete($id)) {
                $_SESSION['message'] = "Data kendaraan berhasil dihapus!";
            } else {
                $_SESSION['message'] = "Gagal menghapus data.";
            }
        }
        header("Location: ?c=vehicle&m=rent");
        exit();
    }
}
