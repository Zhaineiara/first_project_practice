<!--style>
  table, th, td {
    border: 1px solid black;
  }
</style>
        <div class="bag">
            <form action="" method="post" id="buyer_bag">
                <table class="bag_order" id="buyer_bag_order">
                    
                    <tr class="row-bag">
                        <th class = "order-title" >MY ORDER</th>
                    </tr>

                    <tr class="row-bag">
                            <td class="row-content">
                                <p class="number_order">#</p>
                                <img class="img_order" src="images/shop_background.jpg" alt="Image" width="100" height="50"> 
                                <p class="name_order">Product Name</p>
                                <p class="quantity_order">Quantity</p>
                                <p class="price_order">Price</p>
                                <p class="pricetotal_order">Total Price</p>
                            </td>
                    </tr>

                    <tr class="row-bag">
                        <td class="row-content">
                            <p class="number_order">#</p>
                            <img class="img_order" src="images/shop_background.jpg" alt="Image" width="100" height="50"> 
                            <p class="name_order">Product Name</p>
                            <p class="quantity_order">Quantity</p>
                            <p class="price_order">Price</p>
                            <p class="pricetotal_order">Total Price</p>
                        </td>
                    </tr>
                    

                    <tr>
                        <td class="final_amount" >Total Amount: </td>
                    </tr>

                    <tr>
                        <td class="buyer_order_status" >Status: </td>
                    </tr>

                </table>
            </form>
</div-->

<?php
// Assuming $conn is your database connection
if (isset($_SESSION['cid'])) {
    $userId = $_SESSION['cid'];

    // Fetch orders for the specific user with the category 'bag'
    $ordersQuery = $conn->prepare("
        SELECT o.id, o.product_id, o.quantity, o.price, o.total_price, r.status
        FROM orders o
        LEFT JOIN receipt r ON o.id = r.order_id
        WHERE o.user_id = :user_id AND o.category = 'bag'
        ORDER BY o.id ASC
    ");

    $ordersQuery->bindParam(':user_id', $userId);
    $ordersQuery->execute();
    $orders = $ordersQuery->fetchAll();
    
    // Fetch the overall status for the user's bag
    $overallStatusQuery = $conn->prepare("
        SELECT DISTINCT r.status
        FROM orders o
        LEFT JOIN receipt r ON o.id = r.order_id
        WHERE o.user_id = :user_id AND o.category = 'bag'
    ");
    
    $overallStatusQuery->bindParam(':user_id', $userId);
    $overallStatusQuery->execute();
    $overallStatus = $overallStatusQuery->fetchColumn();
} else {
    header("Location: index.php");
    die();
}
?>

<div class="bag">
    <form action="" method="post" id="buyer_bag">
        <table class="bag_order" id="buyer_bag_order">

            <tr class="row-bag">
                <th class="order-title">MY BAG</th>
            </tr>

            <?php
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
                        <!-- Assuming you have a products table to fetch product details -->
                        <?php
                            $productId = $order['product_id'];
                            $productQuery = $conn->prepare("SELECT prod_name, prod_loc FROM products WHERE id = :product_id");
                            $productQuery->bindParam(':product_id', $productId);
                            $productQuery->execute();
                            $product = $productQuery->fetch();
                        ?>
                        <img class="img_order" src="<?= $product['prod_loc'] ?>" alt="Image" width="100" height="50">
                        <p class="name_order"><?= $product['prod_name'] ?></p>
                        <p class="quantity_order">x<?= $order['quantity'] ?></p>
                        <p class="price_order">Price: <?= $order['price'] ?></p>
                        <p class="pricetotal_order">Total Price: <?= $orderTotal ?></p>
                    </td>
                </tr>
            <?php
                $numbering++;
            endforeach;
            ?>

            <!-- Display total amount -->
            <tr>
                <td class="final_amount">Total Amount: &nbsp; &#8369;<?= $totalAmount ?></td>
            </tr>

            <!-- Display overall status -->
            <tr>
                <td class="buyer_order_status">Status: <?= $overallStatus ?></td>
            </tr>
        </table>
    </form>
</div>