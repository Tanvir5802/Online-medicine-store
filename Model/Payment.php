<?php
include_once __DIR__ . "/DatabaseConnection.php";

class Payment
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function create($orderId, $amount, $paymentMethod, $transactionId, $status)
    {
        $sql = "INSERT INTO payments(order_id, amount, payment_method, transaction_id, status) VALUES(?,?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("idsss", $orderId, $amount, $paymentMethod, $transactionId, $status);
        return $statement->execute();
    }

    function findByOrderId($orderId)
    {
        $sql = "SELECT * FROM payments WHERE order_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $orderId);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function updateStatus($orderId, $status)
    {
        $sql = "UPDATE payments SET status=? WHERE order_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $status, $orderId);
        return $statement->execute();
    }
}
?>
