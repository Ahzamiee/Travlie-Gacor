<?php

class Promo extends Model {

    public function __construct() {
        parent::__construct(); // panggil konstruktor dari Model (untuk koneksi DB)
    }

    public function getActivePromos() {
        $query = "SELECT * FROM promos WHERE status = 'active' ORDER BY start_date DESC";
        $stmt = $this->getDbConnection()->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $promos = [];
        while ($row = $result->fetch_assoc()) {
            $promos[] = $row;
        }

        return $promos;
    }

    public function getAllPromos() {
      $query = "SELECT * FROM promos";
      $stmt = $this->getDbConnection()->prepare($query);
      $stmt->execute();
      $result = $stmt->get_result();

      $promos = [];
      while ($row = $result->fetch_object()) {
        $promos[] = $row;
      }

      return $promos; 
    }

    public function getActivePromosFiltered($category) {
      if ($category !== 'All') {
        $query = "SELECT * FROM promos WHERE status = 'active' AND category = ? ORDER BY start_date DESC";
        $stmt = $this->getDbConnection()->prepare($query);
        $stmt->bind_param("s", $category);
      } else {
        $query = "SELECT * FROM promos WHERE status = 'active' ORDER BY start_date DESC";
        $stmt = $this->getDbConnection()->prepare($query);
      }

      $stmt->execute();
      $result = $stmt->get_result();

      $promos = [];
      while ($row = $result->fetch_object()) {
        $promos[] = $row;
      }

      return $promos;
    }

    public function getDefaultPromosFiltered($category) {
    if ($category !== 'All') {
        $query = "SELECT * FROM promos WHERE status = 'active' AND is_default = 1 AND category = ? ORDER BY start_date DESC";
        $stmt = $this->getDbConnection()->prepare($query);
        $stmt->bind_param("s", $category);
    } else {
        $query = "SELECT * FROM promos WHERE status = 'active' AND is_default = 1 ORDER BY start_date DESC";
        $stmt = $this->getDbConnection()->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $promos = [];
    while ($row = $result->fetch_object()) {
        $promos[] = $row;
    }

    return $promos;
}



    public function getPromoById($id) {
        $query = "SELECT * FROM promos WHERE promo_id = ?";
        $stmt = $this->getDbConnection()->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getPromoByCode($code) {
      $query = "SELECT * FROM promos WHERE promo_code = ? LIMIT 1";
      $stmt = $this->getDbConnection()->prepare($query);
      $stmt->bind_param("s", $code); 
      $stmt->execute();
      return $stmt->get_result()->fetch_assoc();
    }

    public function createPromo($data) {
      $query = "INSERT INTO promos (
        title, description, image_url, category, promo_code, discount_type,
        discount_value, start_date, end_date, terms_conditions, status, usage_limit, is_default
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = $this->getDbConnection()->prepare($query);

      $stmt->bind_param(
        "ssssssdssssis",
        $data['title'],
        $data['description'],
        $data['image_url'],
        $data['category'],
        $data['promo_code'],
        $data['discount_type'],
        $data['discount_value'],
        $data['start_date'],
        $data['end_date'],
        $data['terms_conditions'],
        $data['status'],
        $data['usage_limit'],
        $data['is_default']
      );
    return $stmt->execute();
    }

    // Update promo berdasarkan ID
    public function updatePromo($id, $data) {
      $query = "UPDATE promos SET 
        title = ?, 
        description = ?, 
        image_url = ?, 
        category = ?, 
        promo_code = ?, 
        discount_type = ?, 
        discount_value = ?, 
        start_date = ?, 
        end_date = ?, 
        terms_conditions = ?, 
        status = ?, 
        usage_limit = ?, 
        is_default = ?
        WHERE promo_id = ?";

      $stmt = $this->getDbConnection()->prepare($query);

      $stmt->bind_param(
        'ssssssdssssiii',
        $data['title'],
        $data['description'],
        $data['image_url'],
        $data['category'],
        $data['promo_code'],
        $data['discount_type'],
        $data['discount_value'],
        $data['start_date'],
        $data['end_date'],
        $data['terms_conditions'],
        $data['status'],
        $data['usage_limit'],
        $data['is_default'],
        $id
      );

      return $stmt->execute();
    }

    // Hapus promo berdasarkan ID
    public function deletePromo($id) {
        $query = "DELETE FROM promos WHERE promo_id = ?";
        $stmt = $this->getDbConnection()->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getDefaultsByCategory($category) {
    // Siapkan variabel untuk parameter dan tipenya
    $params = [];
    $types = '';

    // Query dasar untuk mengambil promo yang default, aktif, dan belum kedaluwarsa
    $sql = "SELECT * FROM promos WHERE is_default = 1 AND status = 'active' AND end_date >= CURDATE()";

    // Jika kategori yang dipilih bukan 'All', tambahkan filter
    if ($category !== 'All') {
        $sql .= " AND category = ?";
        $params[] = $category;
        $types .= 's';
    }

    // PERBAIKAN: Tambahkan ORDER BY untuk mengambil yang terbaru, dan LIMIT untuk membatasi jumlahnya
    $sql .= " ORDER BY created_at DESC LIMIT 4";

    // Gunakan koneksi database Anda (sesuaikan jika perlu)
    $db = $this->getDbConnection();
    $stmt = $db->prepare($sql);

    // Bind parameter hanya jika ada
    if (!empty($params)) {
        // Menggunakan spread operator (...) untuk bind semua parameter sekaligus
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
