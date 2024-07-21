<?php
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
