<?php
// update_quantity.php

// Assuming $conn is your database connection
include_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $newQuantity = $_POST['newQuantity'];

    // Ensure that 'newQuantity' is set and is a number
    if (isset($newQuantity) && is_numeric($newQuantity)) {
        // TODO: Perform the necessary validation and update in your database
        $updateQuery = $conn->prepare("UPDATE orders SET quantity = :newQuantity WHERE id = :orderId");
        $updateQuery->bindParam(':newQuantity', $newQuantity);
        $updateQuery->bindParam(':orderId', $orderId);

        if ($updateQuery->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'Invalid new quantity value';
    }
} else {
    echo 'Invalid request';
}
?>
