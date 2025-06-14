<?php
// File: models/Order.php
require_once 'models/Model.php';
class Order extends Model {


    public function getAllOrders() {
        $sql = "SELECT *, CONCAT(order_name, order_code) AS full_order_id 
                FROM orders 
                ORDER BY order_date DESC";
        $result = $this->dbconn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersByUserId($user_id) {
    $sql = "SELECT *, CONCAT(order_name, order_code) AS full_order_id 
            FROM orders 
            WHERE user_id = ?
            ORDER BY order_date DESC";
    $stmt = $this->dbconn->prepare($sql);
    if (!$stmt) return [];

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders;
}

    public function getOrderByOrderCode($order_code) {
        $sql = "SELECT *, CONCAT(order_name, order_code) AS full_order_id 
                FROM orders 
                WHERE order_code = ?";
        $stmt = $this->dbconn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("i", $order_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function createOrder($user_id, $order_name, $order_title, $category, $detail, $total_price, $status) {
        $sql = "INSERT INTO orders (user_id, order_name, order_title, category, detail, total_price, status, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->dbconn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("issssss", $user_id, $order_name, $order_title, $category, $detail, $total_price, $status);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    public function updateOrder($order_code, $order_title, $category, $detail, $total_price, $status) {
        $sql = "UPDATE orders SET order_title = ?, category = ?, detail = ?, total_price = ?, status = ? WHERE order_code = ?";
        $stmt = $this->dbconn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("sssssi", $order_title, $category, $detail, $total_price, $status, $order_code);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
    public function deleteOrderByCode($order_code) {
        $stmt = $this->dbconn->prepare("DELETE FROM orders WHERE order_code = ?");
        if (!$stmt) return false;
        $stmt->bind_param("i", $order_code);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    public function updateStatus($order_code, $new_status) {
    $sql = "UPDATE orders SET status = ? WHERE order_code = ?";
    $stmt = $this->dbconn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_code);
    return $stmt->execute();
}

}
