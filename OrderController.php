<?php
class OrderController extends Controller  {
    private $model;

    public function __construct() {
        require_once 'models/Order.php';
        $this->model = new Order();
    }

public function index() {
    $all_orders = $this->model->getAllOrders(); 
    

    foreach ($all_orders as $key => $order) {
        $status_class = '';
        switch ($order['status']) {
            case 'Menunggu Pembayaran':
                $status_class = 'bg-warning text-dark';
                break;
            case 'Sudah Selesai':
                $status_class = 'bg-success';
                break;
            case 'Pesanan Dibatalkan':
                $status_class = 'bg-danger';
                break;
            default:
                $status_class = 'bg-secondary';
                break;
        }
        // Tambahkan key baru ke array order
        $all_orders[$key]['status_class'] = $status_class;
    }
    
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
