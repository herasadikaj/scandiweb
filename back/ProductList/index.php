<?php 
include "header.php";
include "conn.php";
include "product.php";

$con = (new Connect())->conn;

$bookQuery = "SELECT sku, name, price, 'Book' as type, weight as attribute FROM book";
$dvdQuery = "SELECT sku, name, price, 'DVD' as type, size as attribute FROM dvd";
$furnitureQuery = "SELECT sku, name, price, 'Furniture' as type, height, width, length FROM furniture";

$bookResult = mysqli_query($con, $bookQuery);
$dvdResult = mysqli_query($con, $dvdQuery);
$furnitureResult = mysqli_query($con, $furnitureQuery);

if (!$bookResult || !$dvdResult || !$furnitureResult) {
    die("Query Failed: " . mysqli_error($con));
}

$allProducts = [];

while ($row = $bookResult->fetch_assoc()) {
    $allProducts[] = $row;
}

while ($row = $dvdResult->fetch_assoc()) {
    $allProducts[] = $row;
}

while ($row = $furnitureResult->fetch_assoc()) {
    $row['attribute'] = $row['height'] . ' x ' . $row['width'] . ' x ' . $row['length'];
    $allProducts[] = $row;
}

usort($allProducts, function($a, $b) {
    return strcmp($a['sku'], $b['sku']);
});

$displayProducts = array_slice($allProducts, 0, 12);
?>

<section class="mt-5">
    <div class="container">
        <form id="massDeleteForm" action="delete.php" method="post">
            <div class="row">
                <?php
                if (count($displayProducts) > 0) {
                    $counter = 0;
                    foreach ($displayProducts as $row) {
                        if ($row['type'] == 'DVD') {
                            $product = new DVD($row['sku'], $row['name'], $row['price'], $row['attribute']);
                        } elseif ($row['type'] == 'Book') {
                            $product = new Book($row['sku'], $row['name'], $row['price'], $row['attribute']);
                        } elseif ($row['type'] == 'Furniture') {
                            $product = new Furniture($row['sku'], $row['name'], $row['price'], $row['height'], $row['width'], $row['length']);
                        } else {
                            $product = new Product($row['sku'], $row['name'], $row['price']);
                        }
                        ?>
                        <div class="col-md-3 mb-4">
                            <div class="product-card">
                                <input type="checkbox" name="delete_ids[]" value="<?php echo $row['sku']; ?>" class="delete-checkbox">
                                <div class="product-details">
                                    <?php $product->display(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $counter++;
                       
                        if ($counter % 4 == 0 && $counter < 12) {
                            echo '</div><div class="row">';
                        }
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
            <button type="submit" class="delete-checkbox">Mass Delete</button>
            <a href="../ProductAdd/index.php" class="btn btn-primary mt-3">Add</a>
        </form>
    </div>
</section>

<?php 
include "footer.php";
?>
