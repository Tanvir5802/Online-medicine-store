<?php
include_once __DIR__ . "/DatabaseConnection.php";

class Category
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function getAll()
    {
        $result = $this->connection->query("SELECT * FROM categories ORDER BY name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function findById($id)
    {
        $sql = "SELECT * FROM categories WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function create($name, $categoryType)
    {
        $sql = "INSERT INTO categories(name, category_type) VALUES(?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ss", $name, $categoryType);
        return $statement->execute();
    }

    function update($id, $name, $categoryType)
    {
        $sql = "UPDATE categories SET name=?, category_type=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ssi", $name, $categoryType, $id);
        return $statement->execute();
    }

    function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }

    function hasMedicines($id)
    {
        $sql = "SELECT COUNT(*) AS total FROM medicines WHERE category_id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc()["total"] > 0;
    }

    function countAll()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM categories");
        return $result->fetch_assoc()["total"];
    }
}
?>
