<!--style>
  table, th, td {
    border: 1px solid black;
  }
</style-->


<!--STATIC VERSION-->
<!--div class="cart">
            <form action="" method="post" id="buyer_cart">
                <table class="cart_order" id="buyer_cart_order">
                    
                    <tr class="row-cart">
                        <th class="order-title" colspan="6">CUSTOMER ORDER</th>
                    </tr>

                    <tr class="cat-cart">
                        <th>
                            <p class = "id_num">#</p>
                            <p class = "cus_name">NAME</p>
                            <p class = "ord_date">DATE</p>
                            <p class = "cus_profile">PROFILE</p>
                            <p class = "cus_order">ORDER</p>
                            <p class = "ord_status">STATUS</p>
                        </th>
                    </tr>

                    <tr class="cus-cart">
                        <td class = "id_num_info"><p>1</p></td>
                        <td class = "cus_name_info"><p>Precious Daniella Mapa</p></td>
                        <td class = "ord_date_info"><p>12/12/2023</p></td>
                        <td class = "cus_profile_info"><p><button class="order_btn">View Profile</button></p></td>
                        <td class = "cus_order_info"><p><button class="order_btn">View Order</button></p></td>
                        <td class = "square_info"><p><div class="square"></div></p></td>
                        <td class = "stat_info"><p>Incomplete</p></td>
                        <td class = "cus_stat_info"><p><button class="order_btn">Change Status</button></p></td>
                    </tr>

                    <tr class="cus-cart">
                        <td class = "id_num_info"><p>1</p></td>
                        <td class = "cus_name_info"><p>Precious Daniella Mapa</p></td>
                        <td class = "ord_date_info"><p>12/12/2023</p></td>
                        <td class = "cus_profile_info"><p><button class="order_btn">View Profile</button></p></td>
                        <td class = "cus_order_info"><p><button class="order_btn">View Order</button></p></td>
                        <td class = "square_info"><p><div class="square"></div></p></td>
                        <td class = "stat_info"><p>Incomplete</p></td>
                        <td class = "cus_stat_info"><p><button class="order_btn">Change Status</button></p></td>
                    </tr>

                    <tr class="cus-cart">
                        <td class = "id_num_info"><p>1</p></td>
                        <td class = "cus_name_info"><p>Precious Daniella Mapa</p></td>
                        <td class = "ord_date_info"><p>12/12/2023</p></td>
                        <td class = "cus_profile_info"><p><button class="order_btn">View Profile</button></p></td>
                        <td class = "cus_order_info"><p><button class="order_btn">View Order</button></p></td>
                        <td class = "square_info"><p><div class="square"></div></p></td>
                        <td class = "stat_info"><p>Incomplete</p></td>
                        <td class = "cus_stat_info"><p><button class="order_btn">Change Status</button></p></td>
                    </tr>

                    <tr class="cus-cart">
                        <td class = "id_num_info"><p>1</p></td>
                        <td class = "cus_name_info"><p>Precious Daniella Mapa</p></td>
                        <td class = "ord_date_info"><p>12/12/2023</p></td>
                        <td class = "cus_profile_info"><p><button class="order_btn">View Profile</button></p></td>
                        <td class = "cus_order_info"><p><button class="order_btn">View Order</button></p></td>
                        <td class = "square_info"><p><div class="square"></div></p></td>
                        <td class = "stat_info"><p>Incomplete</p></td>
                        <td class = "cus_stat_info"><p><button class="order_btn">Change Status</button></p></td>
                    </tr>


                </table>
            </form>
        </div-->       

<?php
// Assuming $conn is your database connection
include_once("connection.php");

// Fetch data from the receipt table
$receiptQuery = $conn->prepare("
    SELECT r.id AS receipt_id, r.user_id, r.order_id, u.fname, u.mname, u.lname, r.created_at AS order_date,
           r.status AS order_status
    FROM receipt r
    INNER JOIN users u ON r.user_id = u.id
    WHERE status = 'Incomplete'
    ORDER BY r.created_at ASC
");

$receiptQuery->execute();
$receipts = $receiptQuery->fetchAll();
?>

<!-- Display the customer orders -->
<div class="cart">
    <form action="" method="post" id="buyer_cart">
        <table class="cart_order" id="buyer_cart_order">
            <tr class="row-cart">
                <th class="order-title" colspan="6">CUSTOMER ORDERS</th>
            </tr>
            <tr class="cat-cart">
                <th>
                    <p class="id_num">#</p>
                    <p class="cus_name">NAME</p>
                    <p class="ord_date">DATE</p>
                    <p class="cus_profile">PROFILE</p>
                    <p class="cus_order">ORDER</p>
                    <p class="ord_status">STATUS</p>
                </th>
            </tr>

            <?php foreach ($receipts as $index => $receipt) : ?>
                <tr class="cus-cart">
                    <td class="id_num_info"><p><?= $index + 1 ?></p></td>
                    <td class="cus_name_info"><p><?= $receipt['fname'] . ' ' . $receipt['mname'] . ' ' . $receipt['lname'] ?></p></td>

                    <td class="ord_date_info"><p><?= date('m/d/Y', strtotime($receipt['order_date'])) ?></p></td>
                    <td class="cus_profile_info">
                        <p><a href="view_cus_profile.php?user_id=<?= $receipt['user_id'] ?>" class="order_btn">View Profile</a></p>
                    </td>
                    
                    <td class="cus_order_info">
                        <p><a href="view_cus_order.php?user_id=<?= $receipt['user_id'] ?>&order_id=<?= $receipt['order_id'] ?>" class="order_btn">View Order</a></p>
                    </td>

                    <td class="square_info">
                        <p><div class="square <?= ($receipt['order_status'] == 'Complete') ? 'green' : 'red' ?>"></div></p>
                    </td>
                    <td class="stat_info" id="status_<?= $receipt['receipt_id'] ?>"><p><?= $receipt['order_status'] ?></p></td>
                    <td class="cus_stat_info">
                        <p><button class="order_btn" onclick="changeStatus(<?= $receipt['receipt_id'] ?>)">Change Status</button></p>
                    </td>
                </tr>
            <?php endforeach; ?>
            
        </table>
    </form>
</div>


<!-- Add this script at the end of your HTML or in the head section -->
<script>
function changeStatus(receiptId) {
    // Get the current status cell element
    const statusElement = document.querySelector(`#status_${receiptId}`);
    console.log('Current Status:', statusElement.textContent.trim());

    // Determine the new status
    const newStatus = (statusElement.textContent.trim() === 'Complete') ? 'Incomplete' : 'Complete';

    // Make an asynchronous request to change_status.php
    fetch(`change_status.php?receipt_id=${receiptId}`)
        .then(response => response.text())
        .then(data => {
            // Log the response for debugging
            console.log('Response:', data);

            // Check if the status was changed successfully
            if (data === 'success') {
                // Update the UI with the new status
                statusElement.textContent = newStatus;
                statusElement.classList.toggle('green');
                statusElement.classList.toggle('red');

                // Optionally show a success message
                alert(`Status changed successfully to ${newStatus}.`);
                console.log('Updated Status:', statusElement.textContent.trim());
            } else {
                // Handle errors or show an error message
                alert('Failed to change status. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

</script>



        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <!--div class="bag">
            <form action="" method="post" id="buyer_bag">
                <table class="bag_order" id="buyer_bag_order">                         
                <tr>
                        <th>MY ORDER</th>
                    </tr>

                    <tr>
                        <td>
                            <p>#</p>
                            <p>Picture</p>
                            <p>Product Name</p>
                            <p>Quantity</p>
                            <p>Total Price</p>
                            <p>Plus</p>
                            <p>Number</p>
                            <p>Minus</p>
                            <p>Delete</p>
                        </td>
                    </tr>

                    <tr>
                        <td>Total Amount</td>
                        <td>Pesos</td>
                    </tr>

                    <tr>
                        <td>Cancel order</td>
                        <td>Checkout order</td>
                    </tr>

                </table>
            </form>
        </div-->