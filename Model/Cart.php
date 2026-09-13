<?php
include_once __DIR__ . "/DatabaseConnection.php";

class Cart
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function getUserCart($userId)
    {
        $sql = "SELECT cart.id AS cart_id, cart.quantity, medicines.id AS medicine_id, medicines.name, medicines.vendor_name, medicines.price, medicines.availability, medicines.image_path
                FROM cart INNER JOIN medicines ON cart.medicine_id=medicines.id
                WHERE cart.user_id=? ORDER BY cart.added_at DESC";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getItemById($cartId, $userId)
    {
        $sql = "SELECT * FROM cart WHERE id=? AND user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ii", $cartId, $userId);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function addItem($userId, $medicineId, $quantity)
    {
        $sql = "SELECT * FROM cart WHERE user_id=? AND medicine_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ii", $userId, $medicineId);
        $statement->execute();
        $existing = $statement->get_result()->fetch_assoc();

        if ($existing) {
            $newQuantity = intval($existing["quantity"]) + intval($quantity);
            $sql = "UPDATE cart SET quantity=? WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("ii", $newQuantity, $existing["id"]);
            return $statement->execute();
        }

        $sql = "INSERT INTO cart(user_id, medicine_id, quantity) VALUES(?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("iii", $userId, $medicineId, $quantity);
        return $statement->execute();
    }

    function updateQuantity($cartId, $userId, $quantity)
    {
        $sql = "UPDATE cart SET quantity=? WHERE id=? AND user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("iii", $quantity, $cartId, $userId);
        return $statement->execute();
    }

    function removeItem($cartId, $userId)
    {
        $sql = "DELETE FROM cart WHERE id=? AND user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ii", $cartId, $userId);
        return $statement->execute();
    }

    function clearCart($userId)
    {
        $sql = "DELETE FROM cart WHERE user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        return $statement->execute();
    }

    function countItems($userId)
    {
        $sql = "SELECT COALESCE(SUM(quantity),0) AS total FROM cart WHERE user_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        return $statement->get_result()->fetch_assoc()["total"];
    }
}
?>
