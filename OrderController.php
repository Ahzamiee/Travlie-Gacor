<?php
class OrderController extends Controller  {
    private $model;

    public function __construct() {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?c=auth&m=login');
        exit();
    }

    require_once 'models/Order.php';
    $this->model = new Order();
}

public function createForm() {
    $this->loadView('order/create');
}

public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user']['user_id'];

        $order_name = "TRVL-"; // atau bisa dibuat lebih dinamis
        $order_title = $_POST['order_title'];
        $category = $_POST['category'];
        $detail = $_POST['detail'];
        $total_price = str_replace(['Rp', '.', ','], '', $_POST['total_price']);
        $status = "Menunggu Pembayaran";

        $this->model->createOrder($user_id, $order_name, $order_title, $category, $detail, $total_price, $status);

        header("Location: ?c=order&m=index");
        exit();
    }
}



public function index() {
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
    $isAdmin = $user['role'] === 'admin';

    if ($isAdmin) {
        // Admin bisa melihat semua pesanan
        $orders = $this->model->getAllOrders();
    } else {
        // User hanya melihat pesanan miliknya sendiri
        $orders = $this->model->getOrdersByUserId($user_id);
    }

    // Tambahkan status_class berdasarkan status (case-insensitive)
   foreach ($orders as $key => $order) {
    $status = strtoupper(trim($order['status'] ?? ''));
    $status_class = '';

    if ($status === '' || is_null($status)) {
        $status = 'TIDAK ADA STATUS'; // untuk ditampilkan
        $status_class = 'bg-secondary';
    } else {
        switch ($status) {
            case 'MENUNGGU PEMBAYARAN':
                $status_class = 'bg-warning text-dark';
                break;
            case 'SUDAH SELESAI':
                $status_class = 'bg-success';
                break;
            case 'PESANAN DIBATALKAN':
                $status_class = 'bg-danger';
                break;
            default:
                $status_class = 'bg-secondary';
        }
    }

    $orders[$key]['status'] = $status;
    $orders[$key]['status_class'] = $status_class;
}


    // Kirim ke view
    $all_orders = $orders;
    require 'views/order/index.php';
}




    public function checkout() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: index.php?c=order&m=index&status=error');
            exit();
        }

        // Nama parameter di URL tetap 'id' untuk simpel, tapi nilainya adalah order_code
        $order_code = (int)$_GET['id'];

        // PANGGIL METHOD YANG SUDAH KITA UBAH NAMANYA DI MODEL
        $order = $this->model->getOrderByOrderCode($order_code);

        if (!$order) {
            echo "Error: Pesanan tidak ditemukan.";
            exit();
        }
        
        require 'views/order/checkout.php';
        }

    public function invoice() {
        
        if (!isset($_GET['id'])) {
            echo "Error: ID Pesanan tidak valid.";
            exit();
        }
        
        $order_code = $_GET['id'];

    
        $invoice_details = $this->model->getOrderByOrderCode($order_code);

      
        if ($invoice_details) {
            require 'views/order/invoice.php';
        } else {
    
            echo "Error: Invoice untuk pesanan dengan kode '{$order_code}' tidak ditemukan.";
            exit();
        }

    
    }
}
