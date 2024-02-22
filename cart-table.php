<!--style>
  table, th, td {
    border: 1px solid black;
  }
</style-->


<?php
// Assuming $conn is your database connection
include_once("connection.php");

if (isset($_SESSION['cid'])) {
    $userId = $_SESSION['cid'];

    // Fetch orders for the specific user
    $ordersQuery = $conn->prepare("SELECT o.id, p.prod_name, p.prod_loc, o.quantity, o.price, o.total_price
    FROM orders o 
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = :user_id AND category = 'cart'
    ORDER BY p.prod_name ASC");

    $ordersQuery->bindParam(':user_id', $userId);
    $ordersQuery->execute();
    $orders = $ordersQuery->fetchAll();
} else {
    header("Location: index.php");
    die();
}
?>

<div class="cart">
    <form action="" method="post" id="buyer_cart">
        <table class="cart_order" id="buyer_cart_order">
            <tr class="row-cart">
                <th class="order-title">MY ORDER</th>
            </tr>

            <!-- Display orders using php-->
            <?php
            $numbering = 1;
            $totalAmount = 0; // Initialize total amount

            foreach ($orders as $order) :
                // Calculate total for each order
                $orderTotal = $order['quantity'] * $order['price'];
                $totalAmount += $orderTotal; // Accumulate the total
            ?>

            <tr class="row-cart">
                <td class="row-content">
                    <p class="number_order"><?= $numbering ?></p>
                    <img class="img_order" src="<?= $order['prod_loc'] ?>" alt="Image" width="100" height="50">
                    <p class="name_order"><?= $order['prod_name'] ?></p>
                    <p class="quantity_order">x<span id="quantity_<?= $order['id'] ?>"><?= $order['quantity'] ?></span></p>
                    <p class="price_order">Price: <?= $order['price'] ?></p>
                    <p class="pricetotal_order">Total Price: <?= $orderTotal ?></p>
                    <button class="minus-q" onclick="decreaseQuantity(<?= $order['id'] ?>)"><img src="feather-light/minus-circle.svg" alt="minus icon" class="minus-q-btn"></button>
                    <p class="quantity_counter"><?= $order['quantity'] ?></p>
                    <button class="plus-q" onclick="increaseQuantity(<?= $order['id'] ?>)"><img src="feather-light/plus-circle.svg" alt="plus icon" class="plus-q-btn"></button>
                    <button class="order_delete" onclick="return deleteOrder(<?= $order['id'] ?>)">
                        <img src="feather-light/trash-2.svg" alt="delete icon" class="del-p-btn">
                    </button>
                </td>
            </tr>
            
            <?php
                $numbering++;
            endforeach;
            ?>

            <!-- Display total amount and buttons -->
            <tr>
                <td class="final_amount">Total Amount:  &nbsp &#8369;<?= $totalAmount ?></td>
            </tr>

            <tr>
                <td class="order-c">
                    <button id="cancel_order" onclick="cancelOrder()">Cancel Order</button>
                    <button id="check_order" onclick="modifyOrderCategory()">Checkout Order</button>
                </td>
            </tr>



        </table>
    </form>
</div>
  
   
        
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Update the JavaScript functions with AJAX requests -->
<!--add order-->
<script>
    function updateQuantity(orderId, newQuantity) {
        // AJAX request to update the quantity in the database
        $.ajax({
            url: 'update_quantity.php', // Replace with your PHP file handling the update
            method: 'POST',
            data: { orderId: orderId, newQuantity: newQuantity },
            success: function(response) {
                // Update the UI only if the database update is successful
                if (response === 'success') {
                    var quantityElement = $('#quantity_' + orderId);
                    quantityElement.text(newQuantity);
                } else {
                    alert('Failed to update quantity in the database.');
                }
            },
            error: function() {
                alert('Failed to connect to the server.');
            }
        });
    }

    function decreaseQuantity(orderId) {
        // Get the current quantity
        var quantityElement = $('#quantity_' + orderId);
        var currentQuantity = parseInt(quantityElement.text());

        if (currentQuantity > 1) {
            // Decrease the quantity by 1
            var newQuantity = currentQuantity - 1;
            updateQuantity(orderId, newQuantity);
        }
    }

    function increaseQuantity(orderId) {
        // Get the current quantity
        var quantityElement = $('#quantity_' + orderId);
        var currentQuantity = parseInt(quantityElement.text());

        // Increase the quantity by 1
        var newQuantity = currentQuantity + 1;
        updateQuantity(orderId, newQuantity);
    }
</script>

<!--delete order-->
<script>
    function deleteOrder(orderId) {
        // Redirect to delete_product.php with the order ID as a parameter
        window.location.href = 'delete_product.php?id=' + orderId;
        return false; // Prevent default form submission
    }
</script>

<!--cancer order-->
<script>
    function cancelOrder() {
        // AJAX request to delete_cart_order.php
        $.ajax({
            url: 'delete_cart_order.php',
            method: 'POST',
            success: function(response) {
                // Handle the response as needed
                console.log(response);

                // Redirect or perform other actions based on the response
            },
            error: function() {
                alert('Failed to connect to the server.');
            }
        });
    }
</script>

<!--deletec order-->
<script>
    function checkOrder(orderId) {
        // Redirect to delete_product.php with the order ID as a parameter
        window.location.href = 'check_product.php?id=' + orderId;
        return false; // Prevent default form submission
    }
</script>

<script>
    function modifyOrderCategory() {
        $.ajax({
            url: 'checkout_order.php',
            method: 'POST',
            success: function(response) {
                if (response === 'success') {
                    // Handle success (e.g., display a success message, redirect, etc.)
                    console.log('Checkout successful');
                } else if (response === 'not_logged_in') {
                    console.log('User not logged in');
                } else {
                    console.log('Checkout failed');
                }
            },
            error: function() {
                alert('Failed to connect to the server.');
            }
        });
        return false;
    }
</script>

