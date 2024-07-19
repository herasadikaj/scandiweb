<?php 
include "header.php";
include "conn.php";
include "addproduct.php";
?>
 <script>
    function showAttributes() {
        const productType = document.getElementById("productType").value;
        document.getElementById("dvdAttributes").style.display = "none";
        document.getElementById("bookAttributes").style.display = "none";
        document.getElementById("furnitureAttributes").style.display = "none";

        if (productType === "DVD") {
            document.getElementById("dvdAttributes").style.display = "block";
        } else if (productType === "Book") {
            document.getElementById("bookAttributes").style.display = "block";
        } else if (productType === "Furniture") {
            document.getElementById("furnitureAttributes").style.display = "block";
        }
    }
    </script>
</head>
<body onload="showAttributes()">
    <form id="product_form" action="addproduct.php" method="post">
        <label for="sku">SKU:</label>
        <input type="text" id="sku" name="sku" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Price ($):</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="productType">Type Switcher:</label>
        <select id="productType" name="productType" onchange="showAttributes()">
            <option value="DVD" id="DVD">DVD</option>
            <option value="Book" id="Book">Book</option>
            <option value="Furniture" id="Furniture">Furniture</option>
        </select><br>

        <div id="dvdAttributes" class="attribute">
            <label for="size">Size (MB):</label>
            <input type="text" id="size" name="size"><br>
            <p>Please provide size in MB</p>
        </div>

        <div id="bookAttributes" class="attribute">
            <label for="weight">Weight (Kg):</label>
            <input type="text" id="weight" name="weight"><br>
            <p>Please provide weight in Kg</p>
        </div>

        <div id="furnitureAttributes" class="attribute">
            <label for="height">Height (CM):</label>
            <input type="text" id="height" name="height"><br>
            <label for="width">Width (CM):</label>
            <input type="text" id="width" name="width"><br>
            <label for="length">Length (CM):</label>
            <input type="text" id="length" name="length"><br>
            <p>Please provide dimensions in HxWxL format</p>
        </div>

        <button type="submit">Save</button>
        <button type="button" onclick="window.location.href='index.php'">Cancel</button>
    </form>

<?php 
include "footer.php";
?>