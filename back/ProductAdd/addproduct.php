<?php
include_once "conn.php";
$con = new Connect();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productType = $_POST['productType'];

    // Check if SKU is unique across all tables
    $tables = ['book', 'dvd', 'furniture'];
    foreach ($tables as $table) {
        $stmt = $con->conn->prepare("SELECT sku FROM $table WHERE sku = ?");
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "<script>
                    alert('SKU must be unique.');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        }
        $stmt->close();
    }

    $stmt = null;
    $sql = "";

    if ($productType === 'DVD') {
        $size = $_POST['size'];
        $sql = "INSERT INTO dvd (sku, name, price, size) VALUES (?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssss", $sku, $name, $price, $size);
    } elseif ($productType === 'Book') {
        $weight = $_POST['weight'];
        $sql = "INSERT INTO book (sku, name, price, weight) VALUES (?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssss", $sku, $name, $price, $weight);
    } elseif ($productType === 'Furniture') {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $sql = "INSERT INTO furniture (sku, name, price, height, width, length) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssssss", $sku, $name, $price, $height, $width, $length);
    }

    if ($stmt && $stmt->execute()) {
        echo "<script>
                alert('Data inserted successfully.');
                window.location.href = '../ProductList/index.php';
              </script>";
        exit();
    } else {
        echo "Error: " . ($stmt ? $stmt->error : 'Invalid product type or preparation failed');
    }

    if ($stmt) {
        $stmt->close();
    }
}
?>
