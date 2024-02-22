<?php
// Assuming $conn is your database connection
include_once("connection.php");

// Get the user ID from the query parameters (replace with your actual parameter name)
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch orders for the specific user, sorted by product name alphabetically
    $orderQuery = $conn->prepare("
        SELECT o.id, o.product_id, o.quantity, o.price, p.prod_name, p.prod_loc
        FROM orders o
        INNER JOIN products p ON o.product_id = p.id
        WHERE o.user_id = :user_id
        ORDER BY p.prod_name ASC, o.created_at DESC
    ");
    $orderQuery->bindParam(':user_id', $userId);
    $orderQuery->execute();
    $orders = $orderQuery->fetchAll();

    // Assuming you also want to fetch the overall status (replace $orderId with the actual order ID)
    $orderId = 1; // Replace this with the actual order ID
    $statusQuery = $conn->prepare("
        SELECT status
        FROM receipt
        WHERE order_id = :order_id
    ");
    $statusQuery->bindParam(':order_id', $orderId);
    $statusQuery->execute();
    $overallStatus = $statusQuery->fetchColumn();
} else {
    // Handle the case when user_id is not provided
    echo 'User ID not provided.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/mifamilia_w.png"/>        
    <link rel="stylesheet" href="design/view-cus-order.css"/>    
</head>

<body>
    <div class="bag">
        <form action="" method="post" id="buyer_bag">
            <span id="x-button2" class="close-button-order">&times;</span>

            <table class="bag_order" id="buyer_bag_order">
                <tr class="row-bag" id ="header">
                    <th class="order-title">CUSTOMER ORDER</th>
                </tr>

                <?php
                // Check if $orders is defined
                if (!empty($orders)) {
                    $numbering = 1;
                    $totalAmount = 0;

                    // Display orders using PHP loop
                    foreach ($orders as $order) :
                        $orderTotal = $order['quantity'] * $order['price'];
                        $totalAmount += $orderTotal;
                ?>
                        <tr class="row-bag">
                            <td class="row-content">
                                <p class="number_order"><?= $numbering ?></p>
                                <img class="img_order" src="<?= $order['prod_loc'] ?>" alt="Image" width="100" height="50">
                                <p class="name_order"><?= $order['prod_name'] ?></p>
                                <p class="quantity_order">x<?= $order['quantity'] ?></p>
                                <p class="price_order">Price: <?= $order['price'] ?></p>
                                <p class="pricetotal_order">Total Price: <?= $orderTotal ?></p>
                            </td>
                        </tr>
                <?php
                        $numbering++;
                    endforeach;
                } else {
                    // Handle the case when $orders is empty
                    echo '<tr><td>No orders found.</td></tr>';
                }
                ?>

                <!-- Display total amount -->
                <tr>
                    <td class="final_amount">Total Amount: &nbsp; &#8369;<?= $totalAmount ?></td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>

    <script>
        // Use window.onload to ensure the DOM is fully loaded before attaching the event listener
        window.onload = function() {
            // Find the close button by its ID
            const closeButton = document.getElementById('x-button2');

            // Attach the click event handler
            closeButton.addEventListener('click', function() {
                // Redirect to order.php
                window.location.href = 'order.php';
            });
        };
    </script>

