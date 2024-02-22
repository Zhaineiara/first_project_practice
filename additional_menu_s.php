<?php

	//Fetch
	$sql = "SELECT id, prod_name, prod_price, prod_loc FROM products where prod_type = 'Additional' ORDER BY prod_name ASC";
	$selectProductQuery = $conn->prepare($sql);
	$selectProductQuery->execute();
	$products = $selectProductQuery->fetchAll();
?>

<div class="menu">

    <form action="" method="post" id="sortForm">
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
                    echo "<tr>";
                }
                
                echo "<td class=\"product_box\">";
                echo "<div class=\"card_design\">";
                    echo "<img class=\"product_img\" src=\" " . $item['prod_loc'] . "\" alt=\"Seller Image\"> ";
                    echo "<p class=\"product_name\"> " . $item['prod_name'] . "</p>";
                    echo "<p class=\"product_price\">&#8369;" . $item['prod_price'] . "</p>";
                    echo '<a href="delete_product.php?id=' . $item['id'] . '" id="delete-prod" class="product_delete"><img src="feather-light/trash-2.svg" alt="add icon" class="delete-button"></a>';
                    echo '<a href="edit_product.php?id=' . $item['id'] . '" id="edit-prod" class="product_edit"><img src="feather-light/edit.svg" alt="edit icon" class="edit-button"></a>';


                    /*Alternative 
                    echo "<button id=\"delete-prod\" class=\"product_delete\"><img src=\"feather-light/trash-2.svg\" alt=\"add icon\" class=\"delete-button\"></button> ";
                    echo "<button id=\"edit-prod\" class=\"product_edit\"><img src=\"feather-light/edit.svg\" alt=\"add icon\" class=\"edit-button\"></button> ";
                    */
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

        $.each(products, function (index, item) {
            if (columnCount % 5 === 0) {
                // Start a new row
                tbody.append('<tr>');
            }

            var row = "<td class=\"product_box\">" +
                "<div class=\"card_design\">" +
                "<img class=\"product_img\" src=\"" + item.prod_loc + "\" alt=\"Seller Image\"> " +
                "<p class=\"product_name\">" + item.prod_name + "</p>" +
                "<p class=\"product_price\">&#8369;" + item.prod_price + "</p>" +
                '<a href="delete_product.php?id=' + item['id'] + '" id="delete-prod" class="product_delete"><img src="feather-light/trash-2.svg" alt="add icon" class="delete-button"></a>' +
                '<a href="edit_product.php?id=' + item['id'] + '" id="edit-prod" class="product_edit"><img src="feather-light/edit.svg" alt="edit icon" class="edit-button"></a>' +
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

    $('#sortForm').on('submit', function (event) {
        event.preventDefault();
        console.log('Form submitted'); // Add this line for debugging

        var sortCriteria = $('#sortCriteria').val();

        if (sortCriteria === 'name') {
            products.sort(function (a, b) {
                var nameA = a.prod_name.toUpperCase();
                var nameB = b.prod_name.toUpperCase();
                return nameA.localeCompare(nameB);
            });
        } else if (sortCriteria === 'price') {
            products.sort(function (a, b) {
                return a.prod_price - b.prod_price;
            });
        }

        renderTable();
    });
});

</script>