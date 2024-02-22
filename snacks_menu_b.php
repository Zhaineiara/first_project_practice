<?php

	//Fetch
	$sql = "SELECT id, prod_name, prod_price, prod_loc FROM products where prod_type = 'Snack' ORDER BY prod_name ASC";
	$selectProductQuery = $conn->prepare($sql);
	$selectProductQuery->execute();
	$products = $selectProductQuery->fetchAll();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        // Get the selected product ID, quantity, and user ID from the form
        $productId = $_POST['product_id'];
        $quantity = 1; // You can modify this if you have a quantity input in your form
        $userId = $_SESSION['cid'];

        // Check if the product is already in the user's cart
        $existingOrderSql = "SELECT id, quantity, price FROM orders WHERE user_id = :user_id AND product_id = :product_id";
        $existingOrderQuery = $conn->prepare($existingOrderSql);
        $existingOrderQuery->bindParam(':user_id', $userId);
        $existingOrderQuery->bindParam(':product_id', $productId);
        $existingOrderQuery->execute();
        $existingOrder = $existingOrderQuery->fetch();

        if ($existingOrder) {
            // Update the quantity and total price
            $newQuantity = $existingOrder['quantity'] + $quantity;
            $newTotalPrice = $newQuantity * $existingOrder['price'];

            $updateOrderSql = "UPDATE orders SET quantity = :quantity, total_price = :total_price WHERE id = :order_id";
            $updateOrderQuery = $conn->prepare($updateOrderSql);
            $updateOrderQuery->bindParam(':quantity', $newQuantity);
            $updateOrderQuery->bindParam(':total_price', $newTotalPrice);
            $updateOrderQuery->bindParam(':order_id', $existingOrder['id']);
            $updateOrderQuery->execute();
        } else {
            // Fetch the price of the product
            $selectedProductSql = "SELECT prod_price FROM products WHERE id = :product_id";
            $selectedProductQuery = $conn->prepare($selectedProductSql);
            $selectedProductQuery->bindParam(':product_id', $productId);
            $selectedProductQuery->execute();
            $selectedProduct = $selectedProductQuery->fetch();

            if ($selectedProduct && isset($selectedProduct['prod_price'])) {
                $price = $selectedProduct['prod_price'];
                $totalPrice = $quantity * $price;

                // Insert the new order into the orders table
                $insertOrderSql = "INSERT INTO orders (user_id, product_id, quantity, price, total_price)
                                   VALUES (:user_id, :product_id, :quantity, :price, :total_price)";
                $insertOrderQuery = $conn->prepare($insertOrderSql);
                $insertOrderQuery->bindParam(':user_id', $userId);
                $insertOrderQuery->bindParam(':product_id', $productId);
                $insertOrderQuery->bindParam(':quantity', $quantity);
                $insertOrderQuery->bindParam(':price', $price);
                $insertOrderQuery->bindParam(':total_price', $totalPrice);
                $insertOrderQuery->execute();
            } else {
                // Handle the case where the product price is not available
                echo "Error: Product price not found.";
            }
        }
    }
}
?>


<div class="menu">
    <form id="productForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="sort-button">
            <label id="sort-title" for="sortCriteria">Sort by</label>
            <br>
            <select id="sortCriteria" name="sortCriteria">
                <option value="name">Name</option>
                <option value="price">Price</option>
            </select>
            <br>
            <button id="sort-btn" type="submit">Sort</button>
        </div>
    </form>

    <table class="menu_table" id="productTable">                      
    <?php
        $columnCount = 0;
        foreach ($products as $item) {
            if ($columnCount % 5 === 0) {
                // Start a new row
                echo "<tr>";
            }

            echo "<td class=\"product_box\">";
            echo "<div class=\"card_design\">";
            echo "<img class=\"product_img\" src=\"" . $item['prod_loc'] . "\" alt=\"Seller Image\"> ";
            echo "<p class=\"product_name\"> " . $item['prod_name'] . "</p>";
            echo "<p class=\"product_price\">&#8369;" . $item['prod_price'] . "</p>";
            echo "<form action=\"\" method=\"post\">";
            echo "<input type=\"hidden\" name=\"product_id\" value=\"" . $item['id'] . "\">";
            echo "<button class=\"product_add\" type=\"submit\" name=\"add_to_cart\">";
            echo "<img src=\"feather-light/plus-circle.svg\" alt=\"add icon\" class=\"add-button\">";
            echo "</button>";
            echo "</form>";
            echo "</div>";
            echo "</td>";

            $columnCount++;

            if ($columnCount % 5 === 0) {
                // Close the row
                echo "</tr>";
            }
        }

        if ($columnCount % 5 !== 0) {
            echo "</tr>";
        }
    ?>
    </table>    


</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        var products = <?php echo json_encode($products); ?>;

        function renderTable() {
            var tbody = $('#productTable tbody');
            tbody.empty();

            var columnCount = 0;

            $.each(products, function(index, item) {
                if (columnCount % 5 === 0) {
                    // Start a new row
                    tbody.append('<tr>');
                }

                var row = "<td class=\"product_box\">" +
                    "<div class=\"card_design\">" +
                    "<img class=\"product_img\" src=\"" + item.prod_loc + "\" alt=\"Seller Image\"> " +
                    "<p class=\"product_name\">" + item.prod_name + "</p>" +
                    "<p class=\"product_price\">&#8369;" + item.prod_price + "</p>" +
                    "<button class=\"product_add\"><img src=\"feather-light/plus-circle.svg\" alt=\"add icon\" class=\"add-button\"></button> " +         
                    "</div>" +
                    "</td>";

                tbody.append(row);

                // Increment columnCount
                columnCount++;

                if (columnCount % 5 === 0) {
                    // Close the row
                    tbody.append('</tr>');
                }
            });
        }

        $('#productForm').on('submit', function(event) {
            event.preventDefault();

            var sortCriteria = $('#sortCriteria').val();

            if (sortCriteria === 'name') {
                products.sort(function(a, b) {
                    var nameA = a.prod_name.toUpperCase();
                    var nameB = b.prod_name.toUpperCase();
                    return nameA.localeCompare(nameB);
                });
            } else if (sortCriteria === 'price') {
                products.sort(function(a, b) {
                    return a.prod_price - b.prod_price;
                });
            }

            renderTable();
        });
    });
</script>
