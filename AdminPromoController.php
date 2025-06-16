<?php

class AdminPromoController extends Controller {
    private $promoModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login dan berperan sebagai admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?c=dashboard&m=index');
            exit("Akses Ditolak.");
        }

        $this->promoModel = $this->loadModel('Promo');
    }

    public function createform() {
        $this->loadView('promo/create', ['title' => 'Tambah Promo']);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi: cek apakah promo_code sudah digunakan
            $existing = $this->promoModel->getPromoByCode($_POST['promo_code']);
            if ($existing) {
                $_SESSION['error'] = 'Kode promo sudah digunakan!';
                header('Location: ?c=adminPromo&m=createForm');
                exit();
            }
            // Simpan promo baru
            $this->promoModel->createPromo([
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
            header('Location: ?c=adminPromo&m=index');
            exit();
        }
    }

    
    public function edit() {
      if (!isset($_GET['id'])) {
        $_SESSION['error'] = 'ID promo tidak ditemukan!';
        header('Location: ?c=adminPromo&m=index');
        exit();
      }
      
      $promo = $this->promoModel->getPromoById((int)$_GET['id']);
      if (!$promo) {
        $_SESSION['error'] = 'Promo tidak ditemukan!';
        header('Location: ?c=adminPromo&m=index');
        exit();
      }
      
      $this->loadView('promo/edit', [
        'title' => 'Edit Promo',
        'promo' => $promo
      ]);
    }

    public function update() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['promo_id'];
        $existing = $this->promoModel->getPromoByCode($_POST['promo_code']);
        
            // Cegah duplikasi kode promo jika kode yang dikirim berbeda dari yang sebelumnya
            if ($existing && $existing['promo_id'] != $id) {
              $_SESSION['error'] = 'Kode promo sudah digunakan!';
              header("Location: ?c=adminPromo&m=edit&id=" . $id);
              exit();
            }
            
            $this->promoModel->updatePromo($id, [
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
            
            $_SESSION['success'] = 'Promo berhasil diperbarui!';
            header('Location: ?c=adminPromo&m=index');
            exit();
          }
        }

    public function delete() {
            if (isset($_GET['id'])) {
                $this->promoModel->deletePromo((int)$_GET['id']);
                $_SESSION['success'] = 'Promo berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'ID tidak valid!';
            }
            header('Location: ?c=adminPromo&m=index');
            exit();
    }

  }
      
