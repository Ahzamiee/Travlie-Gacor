<?php
class User extends Model {
  public function getByEmail($email) {
    $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_object();

    $stmt->close();
    return $user;
  }


  public function create($fullname, $email, $password, $role = 'user') {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->dbconn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $hashed, $role);
    return $stmt->execute();
  }

  public function updateProfile($oldEmail, $fullname, $newEmail) {
    $stmt = $this->dbconn->prepare("UPDATE users SET fullname = ?, email = ? WHERE email = ?");
    $stmt->bind_param("sss", $fullname, $newEmail, $oldEmail);
    return $stmt->execute();
  }

  public function getAll() {
  $result = $this->dbconn->query("SELECT * FROM users");
  return $result->fetch_all(MYSQLI_ASSOC);
}

public function getById($id) {
  $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

public function update($id, $fullname, $email, $role) {
  $stmt = $this->dbconn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE user_id=?");
  $stmt->bind_param("sssi", $fullname, $email, $role, $id);
  return $stmt->execute();
}

public function delete($id) {
  $stmt = $this->dbconn->prepare("DELETE FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $id);
  return $stmt->execute();
}

public function updateAccount($userId, $fullname, $email, $photo = null) {
    if ($photo) {
        $stmt = $this->dbconn->prepare("UPDATE users SET fullname = ?, email = ?, photo = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $fullname, $email, $photo, $userId);
    } else {
        $stmt = $this->dbconn->prepare("UPDATE users SET fullname = ?, email = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $fullname, $email, $userId);
    }

    return $stmt->execute();
}









}
