<?php

  class PromoController extends Controller {
    private $promoModel;

    public function __construct() {
      if (!isset($_SESSION['user'])) {
        header('Location: index.php?c=auth&m=login');
        exit();
    }

      $this->promoModel = $this->loadModel('Promo');
    }

    public function index() {
      $category = $_GET['category'] ?? 'All'; // Ambil dari URL jika ada, default ke 'All'
      $page = $_GET['page'] ?? 1;

      if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
        $promos = $this->promoModel->getActivePromosFiltered($category, $page, $limit = 8);
      } else {
        $promos = $this->promoModel->getDefaultPromosFiltered($category, $page, $limit = 8);
      }

      $this->loadView('promo/index', [
        'promos' => $promos,
        'activeCategory' => $category,      // ✅ ini yang wajib dikirim
        'currentPage' => $page,
        'promoMessage' => $_SESSION['promoMessage'] ?? null,
        'promoSuccess' => $_SESSION['promoSuccess'] ?? null
      ]);

    }

    public function fetchDefaultPromos() {
        // Ambil kategori dari request AJAX, default ke 'All'
        $category = $_GET['category'] ?? 'All';

        // Panggil method di model untuk mengambil data promo
        // Pastikan Anda membuat method ini di file model Anda
        $defaultPromos = $this->promoModel->getDefaultsByCategory($category);

        // Atur header untuk memberitahu browser bahwa ini adalah response JSON
        header('Content-Type: application/json');
        
        // Ubah array PHP menjadi string JSON dan kirim sebagai response
        echo json_encode($defaultPromos);
        
        // Hentikan eksekusi script agar tidak ada output HTML lain yang tercetak
        exit();
    }

  }
