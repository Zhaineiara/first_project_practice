<?php
session_start();
include_once("connection.php");

if (isset($_SESSION['cid'])) {
    $userId = $_SESSION['cid'];

    // Retrieve the order ID for the user
    $getOrderQuery = $conn->prepare("SELECT id FROM orders WHERE user_id = :user_id AND category = 'cart'");
    $getOrderQuery->bindParam(':user_id', $userId);
    $getOrderQuery->execute();
    $orderResult = $getOrderQuery->fetch(PDO::FETCH_ASSOC);

    if ($orderResult) {
        $orderId = $orderResult['id'];

        // Insert a record into the receipt table
        $insertReceiptQuery = $conn->prepare("INSERT INTO receipt (user_id, order_id, status) VALUES (:user_id, :order_id, 'Incomplete')");
        $insertReceiptQuery->bindParam(':user_id', $userId);
        $insertReceiptQuery->bindParam(':order_id', $orderId);

        if ($insertReceiptQuery->execute()) {
            // Update the category in the orders table
            $updateQuery = $conn->prepare("UPDATE orders SET category = 'bag' WHERE user_id = :user_id AND category = 'cart'");
            $updateQuery->bindParam(':user_id', $userId);

            if ($updateQuery->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'receipt_insert_error';
        }
    } else {
        echo 'no_order_found';
    }
} else {
    echo 'not_logged_in';
}
?>
