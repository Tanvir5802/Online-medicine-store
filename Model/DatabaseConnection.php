<?php
class DatabaseConnection
{
    function openConnection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "medicine_shop";

        mysqli_report(MYSQLI_REPORT_OFF);
        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($connection->connect_error) {
            die("Can not connect to the database. Please check XAMPP MySQL and database settings. " . $connection->connect_error);
        }

        $connection->set_charset("utf8mb4");
        return $connection;
    }
}
?>
