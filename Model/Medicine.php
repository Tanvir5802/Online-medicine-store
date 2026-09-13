<?php
include_once __DIR__ . "/DatabaseConnection.php";

class Medicine
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function getAll($keyword = "", $categoryId = "", $vendor = "", $categoryType = "")
    {
        $sql = "SELECT medicines.*, categories.name AS category_name, categories.category_type
                FROM medicines
                INNER JOIN categories ON medicines.category_id=categories.id
                WHERE 1=1";

        if ($keyword) {
            $keywordValue = $this->connection->real_escape_string($keyword);
            $sql .= " AND (medicines.name LIKE '%$keywordValue%' OR medicines.vendor_name LIKE '%$keywordValue%' OR medicines.description LIKE '%$keywordValue%')";
        }
        if ($categoryId && is_numeric($categoryId)) {
            $sql .= " AND medicines.category_id=" . intval($categoryId);
        }
        if ($vendor) {
            $vendorValue = $this->connection->real_escape_string($vendor);
            $sql .= " AND medicines.vendor_name='$vendorValue'";
        }
        if ($categoryType === "solid" || $categoryType === "liquid") {
            $typeValue = $this->connection->real_escape_string($categoryType);
            $sql .= " AND categories.category_type='$typeValue'";
        }

        $sql .= " ORDER BY medicines.created_at DESC";
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getVendors()
    {
        $result = $this->connection->query("SELECT DISTINCT vendor_name FROM medicines ORDER BY vendor_name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function findById($id)
    {
        $sql = "SELECT medicines.*, categories.name AS category_name, categories.category_type
                FROM medicines INNER JOIN categories ON medicines.category_id=categories.id
                WHERE medicines.id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function create($name, $categoryId, $vendorName, $price, $availability, $description, $imagePath)
    {
        $sql = "INSERT INTO medicines(name, category_id, vendor_name, price, availability, description, image_path) VALUES(?,?,?,?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("sisdiss", $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath);
        return $statement->execute();
    }

    function update($id, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath = "")
    {
        if ($imagePath) {
            $sql = "UPDATE medicines SET name=?, category_id=?, vendor_name=?, price=?, availability=?, description=?, image_path=? WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("sisdissi", $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath, $id);
        } else {
            $sql = "UPDATE medicines SET name=?, category_id=?, vendor_name=?, price=?, availability=?, description=? WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("sisdisi", $name, $categoryId, $vendorName, $price, $availability, $description, $id);
        }
        return $statement->execute();
    }

    function usedInOrders($id)
    {
        $sql = "SELECT COUNT(*) AS total FROM order_items WHERE medicine_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc()["total"] > 0;
    }

    function delete($id)
    {
        $sql = "DELETE FROM medicines WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }

    function checkStock($id, $quantity)
    {
        $medicine = $this->findById($id);
        return $medicine && $medicine["status"] === "active" && intval($medicine["availability"]) >= intval($quantity);
    }

    function decreaseStock($id, $quantity)
    {
        $sql = "UPDATE medicines SET availability=availability-? WHERE id=? AND availability>=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("iii", $quantity, $id, $quantity);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    function increaseStock($id, $quantity)
    {
        $sql = "UPDATE medicines SET availability=availability+? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ii", $quantity, $id);
        return $statement->execute();
    }

    function countAll()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM medicines");
        return $result->fetch_assoc()["total"];
    }

    function totalStock()
    {
        $result = $this->connection->query("SELECT COALESCE(SUM(availability),0) AS total FROM medicines");
        return $result->fetch_assoc()["total"];
    }

    function outOfStockCount()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM medicines WHERE availability=0");
        return $result->fetch_assoc()["total"];
    }
}
?>
