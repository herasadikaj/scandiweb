<?php
include 'header.php';
include 'connection.php';
include 'product.php';
class DeleteProduct {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteProducts($ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM products WHERE id IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return "Error preparing statement: " . $this->conn->error;
        }

        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        if ($stmt->execute()) {
            return "Records deleted successfully";
        } else {
            return "Error deleting records: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mass_delete']) && !empty($_POST['delete_ids']) && is_array($_POST['delete_ids'])) {
    $ids = array_map('intval', $_POST['delete_ids']);
    $deleteProduct = new DeleteProduct($conn);
    $message = $deleteProduct->deleteProducts($ids);
    echo $message;
} else {
    echo "No products selected for deletion or invalid input.";
}

include 'footer.php';
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="mass_delete" value="1">
    <input type="checkbox" name="delete_ids[]" value="1"> Product 1<br>
    <input type="checkbox" name="delete_ids[]" value="2"> Product 2<br>
    <input type="checkbox" name="delete_ids[]" value="3"> Product 3<br>
    <button type="submit">Delete Selected Products</button>
</form>
