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
      $category = $_GET['category'] ?? 'All'; 
      $page = $_GET['page'] ?? 1;
      $limit = 8;

      $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

      if ($isAdmin) {
        $promos = $this->promoModel->getAllPromos();
        $this->loadView('promo/index', [
            'title' => 'Kelola Promo',
            'promos' => $promos,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null,
            'isAdmin' => true
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
      } else {
        $promos = $this->promoModel->getDefaultPromosFiltered($category, $page, $limit);
        $this->loadView('promo/index', [
            'title' => 'Promo | Travlie',
            'promos' => $promos,
            'activeCategory' => $category,
            'currentPage' => $page,
            'promoMessage' => $_SESSION['promoMessage'] ?? null,
            'promoSuccess' => $_SESSION['promoSuccess'] ?? null,
            'isAdmin' => false
        ]);
      }
    }


  }
