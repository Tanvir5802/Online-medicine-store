<?php
include_once __DIR__ . "/DatabaseConnection.php";

class Order
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function create($userId, $totalAmount, $shippingAddress, $paymentStatus, $cartItems)
    {
        $this->connection->begin_transaction();

        $sql = "INSERT INTO orders(user_id, total_amount, shipping_address, payment_status) VALUES(?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("idss", $userId, $totalAmount, $shippingAddress, $paymentStatus);
        if (!$statement->execute()) {
            $this->connection->rollback();
            return 0;
        }

        $orderId = $this->connection->insert_id;
        foreach ($cartItems as $item) {
            $sqlItem = "INSERT INTO order_items(order_id, medicine_id, quantity, unit_price) VALUES(?,?,?,?)";
            $itemStatement = $this->connection->prepare($sqlItem);
            $itemStatement->bind_param("iiid", $orderId, $item["medicine_id"], $item["quantity"], $item["price"]);
            if (!$itemStatement->execute()) {
                $this->connection->rollback();
                return 0;
            }
        }

        $this->connection->commit();
        return $orderId;
    }

    function findById($id)
    {
        $sql = "SELECT orders.*, users.name AS customer_name, users.email AS customer_email, users.phone AS customer_phone,
                       payments.payment_method, payments.transaction_id, payments.status AS payment_record_status, payments.payment_date
                FROM orders INNER JOIN users ON orders.user_id=users.id
                LEFT JOIN payments ON payments.order_id=orders.id
                WHERE orders.id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function getItems($orderId)
    {
        $sql = "SELECT order_items.*, medicines.name AS medicine_name, medicines.vendor_name
                FROM order_items INNER JOIN medicines ON order_items.medicine_id=medicines.id
                WHERE order_items.order_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $orderId);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getUserOrders($userId)
    {
        $sql = "SELECT orders.*, payments.payment_method, payments.transaction_id, payments.status AS payment_record_status
                FROM orders LEFT JOIN payments ON payments.order_id=orders.id
                WHERE orders.user_id=? ORDER BY orders.order_date DESC";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getWorkingOrders()
    {
        $sql = "SELECT orders.*, users.name AS customer_name, users.phone AS customer_phone,
                       payments.payment_method, payments.transaction_id, payments.status AS payment_record_status
                FROM orders INNER JOIN users ON orders.user_id=users.id
                LEFT JOIN payments ON payments.order_id=orders.id
                WHERE orders.status IN ('pending','accepted','processing','shipped')
                ORDER BY orders.order_date ASC";
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getCompletedOrders()
    {
        $sql = "SELECT orders.*, users.name AS customer_name,
                       payments.payment_method, payments.transaction_id, payments.status AS payment_record_status
                FROM orders INNER JOIN users ON orders.user_id=users.id
                LEFT JOIN payments ON payments.order_id=orders.id
                WHERE orders.status IN ('delivered','rejected','cancelled')
                ORDER BY orders.order_date DESC";
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function updateStatus($id, $status)
    {
        $sql = "UPDATE orders SET status=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $status, $id);
        return $statement->execute();
    }

    function updatePaymentStatus($id, $status)
    {
        $sql = "UPDATE orders SET payment_status=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $status, $id);
        return $statement->execute();
    }

    function countPending()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM orders WHERE status='pending'");
        return $result->fetch_assoc()["total"];
    }

    function countUserOrders($userId)
    {
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        return $statement->get_result()->fetch_assoc()["total"];
    }

    function countUserPending($userId)
    {
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE user_id=? AND status IN ('pending','accepted','processing','shipped')";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        return $statement->get_result()->fetch_assoc()["total"];
    }

    function countByStatuses($statuses)
    {
        $safe = array();
        foreach ($statuses as $status) {
            $safe[] = "'" . $this->connection->real_escape_string($status) . "'";
        }
        if (!$safe) return 0;
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE status IN (" . implode(",", $safe) . ")";
        $result = $this->connection->query($sql);
        return $result->fetch_assoc()["total"];
    }
}
?>
