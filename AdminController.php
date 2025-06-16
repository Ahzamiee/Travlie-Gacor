<?php


class AdminController extends Controller {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?c=dashboard&m=index');
            exit("Akses Ditolak.");
        }
    }

    public function manageUsers() {
        $userModel = $this->loadModel('User');
        $users = $userModel->getAll();
        $this->loadView('admin/user/index', ['title' => 'Manajemen Pengguna', 'users' => $users]);
    }
    

    public function createOrderForm() {
        $error = $_SESSION['form_error'] ?? null;
        unset($_SESSION['form_error']);

        $this->loadView('admin/orders/create', [
            'title' => 'Tambah Pesanan',
            'error' => $error
        ]);
    }

   
    public function storeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->loadModel('User');
            $orderModel = $this->loadModel('Order');
            
            $user_id = $_POST['user_id'];

            
            $userExists = $userModel->getById($user_id);

            if (!$userExists) {
               
                $_SESSION['form_error'] = "Error: User ID '{$user_id}' tidak ditemukan. Pesanan tidak dapat dibuat.";
                header("Location: ?c=admin&m=createOrderForm");
                exit();
            }

            $orderModel->createOrder(
                $user_id,
                $_POST['order_name'],
                $_POST['order_title'],
                $_POST['category'],
                $_POST['detail'],
                $_POST['total_price'],
                $_POST['status']
            );
            
            header("Location: ?c=admin&m=manageOrders");
            exit();
        }
    }

    public function manageOrders() {
        $orderModel = $this->loadModel('Order');
        $all_orders = $orderModel->getAllOrders();
        $this->loadView('admin/orders/index', [
            'title' => 'Kelola Pesanan',
            'all_orders' => $all_orders
        ]);
    }

    public function editOrderForm() {
        if (isset($_GET['id'])) {
            $orderModel = $this->loadModel('Order');
            $order = $orderModel->getOrderByOrderCode($_GET['id']);
            if ($order) {
                $this->loadView('admin/orders/edit', [
                    'title' => 'Edit Pesanan',
                    'order' => $order
                ]);
            } else {
                echo "Error: Pesanan tidak ditemukan.";
            }
        } else {
            header('Location: ?c=admin&m=manageOrders');
            exit();
        }
    }

    public function updateOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderModel = $this->loadModel('Order');
            $orderModel->updateOrder(
                $_POST['order_code'],
                $_POST['order_title'],
                $_POST['category'],
                $_POST['detail'],
                $_POST['total_price'],
                $_POST['status']
            );
            header("Location: ?c=admin&m=manageOrders");
            exit();
        }
    }

    public function deleteOrder() {
        if (isset($_GET['id'])) {
            $orderModel = $this->loadModel('Order');
            $orderModel->deleteOrderByCode($_GET['id']);
        }
        header("Location: ?c=admin&m=manageOrders");
        exit();
    }

    public function createUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        // Validasi sederhana
        if (empty($fullname) || empty($email) || empty($password)) {
            echo "Semua field harus diisi.";
            return;
        }

        $userModel = $this->loadModel('User');
        $existing = $userModel->getByEmail($email);
        if ($existing) {
            echo "Email sudah terdaftar.";
            return;
        }

        $success = $userModel->create($fullname, $email, $password, $role);
        if ($success) {
            header("Location:?c=admin&m=manageUsers");
            exit();
        } else {
            echo "Gagal menambahkan user.";
        }
    } else {
        $this->loadView('admin/user/create', [
            'title' => 'Tambah User'
        ]);
    }
}

public function editUser() {
    if (!isset($_GET['id'])) {
        echo "User ID tidak ditemukan.";
        return;
    }

    $userModel = $this->loadModel('User');
    $user = $userModel->getById($_GET['id']);

    if ($user) {
        $this->loadView("admin/user/edit", [
            'title' => 'Edit User',
            'user' => $user
        ]);
    } else {
        echo "User tidak ditemukan.";
    }
}

public function updateUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['user_id'] ?? null;
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? 'user';

        $userModel = $this->loadModel('User');
        $updated = $userModel->update($id, $fullname, $email, $role);

        if ($updated) {
            header("Location:?c=admin&m=manageUsers");
            exit();
        } else {
            echo "Gagal memperbarui data user.";
        }
    }
}


public function managePromos() {
    $promoModel = $this->loadModel('Promo');
    $promos = $promoModel->getAllPromos();
    $this->loadView('promo/index', [
        'title' => 'Kelola Promo',
        'promos' => $promos,
        'success' => $_SESSION['success'] ?? null,
        'error' => $_SESSION['error'] ?? null
    ]);
    unset($_SESSION['success'], $_SESSION['error']);
}

public function createPromoForm() {
    $this->loadView('promo/create', ['title' => 'Tambah Promo']);
}

public function storePromo() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $promoModel = $this->loadModel('Promo');
        $existing = $promoModel->getPromoByCode($_POST['promo_code']);
        if ($existing) {
            $_SESSION['error'] = 'Kode promo sudah digunakan!';
            header('Location: ?c=admin&m=createPromoForm');
            exit();
        }

        $promoModel->createPromo([
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'promo_code' => $_POST['promo_code'],
            'category' => $_POST['category'],
            'discount_type' => $_POST['discount_type'],
            'discount_value' => $_POST['discount_value'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'terms_conditions' => $_POST['terms_conditions'],
            'status' => $_POST['status']
        ]);
        
        $_SESSION['success'] = 'Promo berhasil ditambahkan!';
        header('Location: ?c=admin&m=managePromos');
        exit();
    }
}

public function editPromo() {
    if (!isset($_GET['id'])) {
        $_SESSION['error'] = 'ID promo tidak ditemukan!';
        header('Location: ?c=admin&m=managePromos');
        exit();
    }
    
    $promoModel = $this->loadModel('Promo');
    $promo = $promoModel->getPromoById((int)$_GET['id']);
    if (!$promo) {
        $_SESSION['error'] = 'Promo tidak ditemukan!';
        header('Location: ?c=admin&m=managePromos');
        exit();
    }
    
    $this->loadView('promo/edit', [
        'title' => 'Edit Promo',
        'promo' => $promo
    ]);
}



public function updatePromo() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // PERBAIKAN: Load Promo model terlebih dahulu
        $promoModel = $this->loadModel('Promo'); 
        
        $id = (int)$_POST['promo_id'];
        
        // Sekarang $promoModel sudah ada dan bisa digunakan
        $existing = $promoModel->getPromoByCode($_POST['promo_code']);
        
        // Cegah duplikasi kode promo
        if ($existing && $existing['promo_id'] != $id) {
            $_SESSION['error'] = 'Kode promo sudah digunakan!';
            header("Location: ?c=admin&m=editPromo&id=" . $id);
            exit();
        }
        
        // Ambil nilai checkbox 'is_default' dengan aman
        $is_default = isset($_POST['is_default']) ? 1 : 0;

        $dataToUpdate = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'promo_code' => $_POST['promo_code'],
            'category' => $_POST['category'],
            'discount_type' => $_POST['discount_type'],
            'discount_value' => $_POST['discount_value'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'terms_conditions' => $_POST['terms_conditions'],
            'status' => $_POST['status'],
            'is_default' => $is_default // Gunakan variabel yang sudah aman
        ];

        $promoModel->updatePromo($id, $dataToUpdate);
        
        $_SESSION['success'] = 'Promo berhasil diperbarui!';
        header('Location: ?c=promo&m=index');
        exit();
    }
}

public function deletePromo() {
    if (isset($_GET['id'])) {
        $promoModel = $this->loadModel('Promo');
        $promoModel->deletePromo((int)$_GET['id']);
        $_SESSION['success'] = 'Promo berhasil dihapus!';
    } else {
        $_SESSION['error'] = 'ID tidak valid!';
    }
    header('Location: ?c=admin&m=managePromos');
    exit();
}


}
