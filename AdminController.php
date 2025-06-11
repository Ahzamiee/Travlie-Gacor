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

    public function index() {
        $this->loadView('admin/dashboard', ['title' => 'Admin Dashboard']);
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
}
