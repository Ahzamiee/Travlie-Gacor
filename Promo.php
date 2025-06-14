<?php
require_once 'Model.php';

class Promo extends Model {
public function getActivePromos($category = 'All', $limit = 6, $offset = 0, $userId = null) {
    $conn = $this->getDbConnection();
    $today = date("Y-m-d");

    $baseSQL = "
        SELECT * FROM promos 
        WHERE status = 'Active' 
        AND start_date <= ? 
        AND end_date >= ? ";

    if ($category !== 'All') {
        $baseSQL .= "AND category = ? ";
    }

    if ($userId !== null) {
        $baseSQL .= "AND promo_id NOT IN (
            SELECT promo_id FROM user_hidden_promos WHERE user_id = ?
        ) ";
    }

    $baseSQL .= "LIMIT ? OFFSET ?";

    if ($category === 'All' && $userId === null) {
        $stmt = $conn->prepare($baseSQL);
        $stmt->bind_param("ssii", $today, $today, $limit, $offset);
    } elseif ($category === 'All' && $userId !== null) {
        $stmt = $conn->prepare($baseSQL);
        $stmt->bind_param("ssiii", $today, $today, $userId, $limit, $offset);
    } elseif ($category !== 'All' && $userId === null) {
        $stmt = $conn->prepare($baseSQL);
        $stmt->bind_param("sssii", $today, $today, $category, $limit, $offset);
    } else {
        $stmt = $conn->prepare($baseSQL);
        $stmt->bind_param("sssiii", $today, $today, $category, $userId, $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $promos = [];
    while ($row = $result->fetch_object()) {
        $promos[] = $row;
    }
    return $promos;
  }

public function countActivePromos($category = 'All', $userId = null) {
    $conn = $this->getDbConnection();
    $today = date("Y-m-d");

    $sql = "
        SELECT COUNT(*) as total FROM promos 
        WHERE status = 'Active' 
        AND start_date <= ? 
        AND end_date >= ? ";

    if ($category !== 'All') {
        $sql .= "AND category = ? ";
    }

    if ($userId !== null) {
        $sql .= "AND promo_id NOT IN (
            SELECT promo_id FROM user_hidden_promos WHERE user_id = ?
        )";
    }

    if ($category === 'All' && $userId === null) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $today, $today);
    } elseif ($category === 'All' && $userId !== null) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $today, $today, $userId);
    } elseif ($category !== 'All' && $userId === null) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $today, $today, $category);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $today, $today, $category, $userId);
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
