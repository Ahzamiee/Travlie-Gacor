<?php

  class PromoController extends Controller {
    private $promoModel;

    public function __construct() {
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
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

  }
