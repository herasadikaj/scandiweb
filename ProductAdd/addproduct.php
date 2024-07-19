<?php
include "conn.php";
include "index.php";
$con = new Connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productType = $_POST['productType'];
    
  
    $size = $weight = $height = $width = $length = null;
    
 
    if ($productType === 'DVD') {
        $size = $_POST['size'];
    } elseif ($productType === 'Book') {
        $weight = $_POST['weight'];
    } elseif ($productType === 'Furniture') {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
    }

    $sql = "INSERT INTO product (sku, name, price, productType, size, weight, height, width, length) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->conn->prepare($sql);
    $stmt->bind_param("sssssdd", $sku, $name, $price, $productType, $size, $weight, $height, $width, $length);

    if ($stmt->execute()) {
        header("Location: success_page.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
