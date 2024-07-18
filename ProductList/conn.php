<?php

class Connect
{
    public $username = "root";
    public $password = ""; 
    public $server_name = "localhost";
    public $db_name = "productdb";

    public $conn;

    function __construct()
    {
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function select_by_query($query) {
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    function select_all_products()
    {
        $sql = "SELECT * FROM products ORDER BY sku";
        $result = $this->conn->query($sql);
        if ($result === FALSE) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    function select_product_by_sku($sku)
    {
        $sql = "SELECT * FROM products WHERE sku = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function insert_product($sku, $name, $price, $attribute_name, $attribute_value)
    {
        $sql = "INSERT INTO products (sku, name, price, attribute_name, attribute_value) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdss", $sku, $name, $price, $attribute_name, $attribute_value);

        if ($stmt->execute() === TRUE) {
            echo '<script>alert("The product was added successfully");</script>';
        } else {
            echo '<script>alert("' . $this->conn->error . '");</script>';
        }
    }
}

?>
