<?php
  class AuthController extends Controller {
    public function __construct() {
      session_start();
      if (isset($_SESSION['user']) && ($_GET['m'] ?? '') !== 'logout') { //
        header("Location:?c=dashboard&m=index");
        exit();
      }
    }

    public function login() {
      $this->loadView("auth/login", ['title' => 'Login']);
    }

    public function loginProcess() {  
      $title = 'Login';

      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      $userModel = $this->loadModel("User"); 
      $user = $userModel->getByEmail($email);

      if ($user) {
        if (password_verify($password, $user->password)) {
           $_SESSION['user'] = [
              'user_id' => $user->user_id,
              'email' => $user->email,
              'fullname' => $user->fullname,
              'role' => $user->role,
              'photo' => $user->photo
            ];

          header('Location:?c=dashboard&m=index');
          exit();
        } else {
          $this->loadView("auth/login", [
            'title' => 'Login',
            'error' => 'Password salah!',
            'email' => $email
          ], "auth");
        }
      } else {
        $this->loadView("auth/login", [
          'title' => 'Login',
          'error' => 'Email tidak ditemukan!',
          'email' => $email
        ], "auth");
      }
    }

    public function register() {
      $this->loadView("auth/register", ['title' => 'Register'], "auth");
    }

    public function registerProcess() {
      // session_start();

      $title = 'Register';

      $fullname = $_POST['fullname'] ?? '';
      $email = $_POST['email'] ?? '';
      $password = $_POST['password'] ?? '';
      $confirmPassword = $_POST['confirm_password'] ?? '';


      if ($password !== $confirmPassword) {
        $this->loadView(
          "auth/register", 
          [
            'title' => $title,
            'error' => 'Password tidak cocok'
          ]
        );
        return;
      }

      $userModel = $this->loadModel("User");
      $existingUser = $userModel->getByEmail($_POST['email'] ?? '');
      if ($userModel->getByEmail($_POST['email'] ?? '')) {
        $this->loadView(
          "auth/register", 
          [
            'title' => $title,
            'error' => 'Username sudah terdaftar'
          ]
        );
        return;
      }

      // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      if ($userModel->create($fullname, $email, $password)) {
        header("Location:?c=auth&m=login");
      } else {
        $this->loadView(
          "auth/register", 
          [
            'title' => $title,
            'error' => 'Gagal mendaftar, coba lagi'
          ]
        );
      }
    }

    public function forgot_password() {
      $this->loadView("auth/forgot_password", ['title' => 'Forgot Password'], "auth");
    }

    public function logout() {
    session_start();
    session_unset();
    session_destroy();
    header("Location:?c=auth&m=login");
    exit();
    }
  }
