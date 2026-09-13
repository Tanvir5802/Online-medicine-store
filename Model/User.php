<?php
include_once __DIR__ . "/DatabaseConnection.php";

class User
{
    private $connection;

    function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->openConnection();
    }

    function create($name, $email, $password, $role, $address, $phone)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(name, email, password_hash, role, address, phone) VALUES(?,?,?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ssssss", $name, $email, $passwordHash, $role, $address, $phone);
        return $statement->execute();
    }

    function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("s", $email);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function findByEmailAndPhone($email, $phone)
    {
        $sql = "SELECT * FROM users WHERE email=? AND phone=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("ss", $email, $phone);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    function emailExistsForOtherUser($email, $id)
    {
        $sql = "SELECT id FROM users WHERE email=? AND id<>?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $email, $id);
        $statement->execute();
        return $statement->get_result()->num_rows > 0;
    }

    function updateProfile($id, $name, $email, $address, $phone, $profilePicture = "")
    {
        if ($profilePicture) {
            $sql = "UPDATE users SET name=?, email=?, address=?, phone=?, profile_picture=? WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("sssssi", $name, $email, $address, $phone, $profilePicture, $id);
        } else {
            $sql = "UPDATE users SET name=?, email=?, address=?, phone=? WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("ssssi", $name, $email, $address, $phone, $id);
        }
        return $statement->execute();
    }

    function updatePassword($id, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password_hash=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $passwordHash, $id);
        return $statement->execute();
    }

    function deleteProfile($id)
    {
        $sql = "DELETE FROM users WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }

    function getAllUsers()
    {
        $result = $this->connection->query("SELECT * FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function updateRole($id, $role)
    {
        $sql = "UPDATE users SET role=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $role, $id);
        return $statement->execute();
    }

    function updateStatus($id, $status)
    {
        $sql = "UPDATE users SET status=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("si", $status, $id);
        return $statement->execute();
    }

    function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }

    function countAll()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM users");
        return $result->fetch_assoc()["total"];
    }

    function countCustomers()
    {
        $result = $this->connection->query("SELECT COUNT(*) AS total FROM users WHERE role='customer'");
        return $result->fetch_assoc()["total"];
    }
}
?>
