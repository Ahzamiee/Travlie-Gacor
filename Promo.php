<?php
require_once 'Model.php';

class Promo extends Model {
  public function getActivePromos($category = 'All', $limit = 6, $offset = 0) {
    $conn = $this->getDbConnection();
    $today = date("Y-m-d");

    if ($category === 'All') {
        $sql = "SELECT * FROM promos WHERE status = 'Active' AND start_date <= ? AND end_date >= ? LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $today, $today, $limit, $offset);
    } else {
        $sql = "SELECT * FROM promos WHERE status = 'Active' AND start_date <= ? AND end_date >= ? AND category = ? LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $today, $today, $category, $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $promos = [];
    while ($row = $result->fetch_object()) {
        $promos[] = $row;
    }
    return $promos;
  }

  public function countActivePromos($category = 'All') {
    $conn = $this->getDbConnection();
    $today = date("Y-m-d");

    if ($category === 'All') {
        $sql = "SELECT COUNT(*) as total FROM promos WHERE status = 'Active' AND start_date <= ? AND end_date >= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $today, $today);
    } else {
        $sql = "SELECT COUNT(*) as total FROM promos WHERE status = 'Active' AND start_date <= ? AND end_date >= ? AND category = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $today, $today, $category);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] ?? 0;
  }

  public function findByCode($code) {
    $code = $_POST['promo_code'] ?? '';
    $conn = $this->getDbConnection();
    $today = date("Y-m-d");

    $sql = "SELECT * FROM promos 
      WHERE promo_code = ? 
      AND status = 'Active' 
      AND start_date <= ? 
      AND end_date >= ? 
      LIMIT 5";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die("Prepare failed: " . $conn->error);  // ✅ Tambahkan debug ini
    }

    $stmt->bind_param("sss", $code, $today, $today);

    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_object();
  }

  public function incrementUsage($promo_id) {
    $conn = $this->getDbConnection();
    $sql = "UPDATE promos SET usage_count = usage_count + 1 WHERE promo_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $promo_id);
    return $stmt->execute();
  }

  public function deletePromoById($id) {
    $conn = $this->getDbConnection();
    $stmt = $conn->prepare("DELETE FROM promos WHERE promo_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
  }

}
