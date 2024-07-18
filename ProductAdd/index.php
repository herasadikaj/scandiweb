<?php 
include "header.php";


?>

<form id="product_form" action="process.php" method="post">
        <label for="sku">SKU:</label>
        <input type="text" id="sku" name="sku"><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br>

        <label for="price">Price ($):</label>
        <input type="number" id="price" name="price">
        <br>
        <br>
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
    <form>
        <label for="productType">Type Switcher:</label>
        <select id="productType" name="productType" onchange="showAttributes()">
            <option value="DVD" id="DVD">DVD</option>
            <option value="Book" id="Book">Book</option>
            <option value="Furniture" id="Furniture">Furniture</option>
        </select><br>

        <div id="dvdAttributes" class="attribute">
            <label for="size">Size (MB) or Text:</label>
            <input type="text" id="size" name="size"><br>
            <p>Product description: Please provide size in MB or descriptive text</p>
        </div>

        <div id="bookAttributes" class="attribute">
            <label for="weight">Weight (Kg) or Text:</label>
            <input type="text" id="weight" name="weight"><br>
            <p>Product description: Please provide weight in Kg or descriptive text</p>
        </div>

        <div id="furnitureAttributes" class="attribute">
            <label for="height">Height (CM) or Text:</label>
            <input type="text" id="height" name="height"><br>
            <label for="width">Width (CM) or Text:</label>
            <input type="text" id="width" name="width"><br>
            <label for="length">Length (CM) or Text:</label>
            <input type="text" id="length" name="length"><br>
            <p>Product description: Please provide dimensions in HxWxL format or descriptive text</p>
        </div>

        <button type="submit">Save</button>
        <button type="button" onclick="window.location.href='cancel_url_here'">Cancel</button>
    </form>

    <?php 
    include "footer.php";
    ?>