<?php 
include "header.php";
include "connection.php";
include "conn.php";

class Product {
    public $sku;
    public $name;
    public $price;
    
    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getAttribute() {
        return "No specific attribute";
    }

    public function display() {
        echo "<p><b>SKU:</b> {$this->getSku()}</p>";
        echo "<p><b>Name:</b> {$this->getName()}</p>";
        echo "<p><b>Price:</b> \${$this->getPrice()}</p>";
        echo "<p class='attribute'><b>Attribute:</b> {$this->getAttribute()}</p>";
    }
}

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getAttribute() {
        return "Size: {$this->size} MB";
    }
}

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getAttribute() {
        return "Weight: {$this->weight} Kg";
    }
}

class Furniture extends Product {
    private $dimensions;

    public function __construct($sku, $name, $price, $dimensions) {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
    }

    public function getAttribute() {
        return "Dimensions: {$this->dimensions}";
    }
}

?>

<section class="mt-5 ">
    <div class="container">
        <div class="row">
            <?php
            // Ensure connection is established
            $con = include 'connection.php'; // or however you include your connection script

            // Fetch all products from the database
            $query = "SELECT * FROM productsdb"; // Replace 'products' with your actual table name
            $result = mysqli_query($con, $query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product = null;

                    switch ($row['type']) {
                        case 'DVD':
                            $product = new DVD($row['sku'], $row['name'], $row['price'], $row['size']);
                            break;
                        case 'Book':
                            $product = new Book($row['sku'], $row['name'], $row['price'], $row['weight']);
                            break;
                        case 'Furniture':
                            $product = new Furniture($row['sku'], $row['name'], $row['price'], $row['dimensions']);
                            break;
                        default:
                            $product = new Product($row['sku'], $row['name'], $row['price']);
                            break;
                    }

                    if ($product) {
                        ?>
                        <div class="col-md-3 d-flex">
                            <div class="product-card">
                                <img src="<?php echo $row["image"]; ?>" alt="<?php echo $product->getName(); ?>" />
                                <h6><?php echo $product->getName(); ?></h6>
                                <?php $product->display(); ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                echo "<p>No products found.</p>";
            }

            // Close the connection
            mysqli_close($con);
            ?>
        </div>
    </div>
</section>

<style>
    .product-card {
        border: 1px solid #ccc;
        padding: 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card img {
        max-height: 200px;
        object-fit: cover;
    }

    .product-card h6 {
        font-size: 1.1rem;
        margin-top: 15px;
    }

    .product-card p {
        margin: 5px 0;
    }

    .product-card .attribute {
        font-weight: bold;
        margin-top: 10px;
    }
</style>
