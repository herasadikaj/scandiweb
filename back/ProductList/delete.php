<?php
include_once "conn.php"; 

$con = (new Connect())->conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_ids']) && is_array($_POST['delete_ids'])) {
        
        $deleteIds = array_map(function($id) use ($con) {
            return mysqli_real_escape_string($con, $id);
        }, $_POST['delete_ids']);
        
        
        $queries = [
            "DELETE FROM book WHERE sku IN ('" . implode("','", $deleteIds) . "')",
            "DELETE FROM dvd WHERE sku IN ('" . implode("','", $deleteIds) . "')",
            "DELETE FROM furniture WHERE sku IN ('" . implode("','", $deleteIds) . "')"
        ];
        
        foreach ($queries as $query) {
            if (!mysqli_query($con, $query)) {
                die("Deletion Failed: " . mysqli_error($con));
            }
        }
        
        
        header("Location: index.php?message=Products+deleted+successfully");
        exit();
    } else {
       
        header("Location: index.php?message=No+products+selected+for+deletion");
        exit();
    }
} else {
    
    header("Location: index.php?message=Invalid+request");
    exit();
}
?>
