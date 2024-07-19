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

    echo "SKU: $sku<br>";
    echo "Name: $name<br>";
    echo "Price: $price<br>";
    echo "Product Type: $productType<br>";

    $stmt = null;
    $sql = "";

    if ($productType === 'DVD') {
        $size = $_POST['size'];
        echo "Size: $size<br>"; 
        $sql = "INSERT INTO dvd (sku, name, price, size) VALUES (?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssss", $sku, $name, $price, $size);
    } elseif ($productType === 'Book') {
        $weight = $_POST['weight'];
        echo "Weight: $weight<br>"; 
        $sql = "INSERT INTO book (sku, name, price, weight) VALUES (?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssss", $sku, $name, $price, $weight);
    } elseif ($productType === 'Furniture') {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        echo "Height: $height, Width: $width, Length: $length<br>"; 
        $sql = "INSERT INTO furniture (sku, name, price, height, width, length) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->conn->prepare($sql);
        $stmt->bind_param("ssssss", $sku, $name, $price, $height, $width, $length);
    }

    if ($stmt && $stmt->execute()) {
        echo "Data inserted successfully";
        header("Location: success_page.php");
        exit();
    } else {
        echo "Error: " . ($stmt ? $stmt->error : 'Invalid product type or preparation failed');
    }

    if ($stmt) {
        $stmt->close();
    }
}
?>
