<?php
include_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $orderId = $_GET['id'];

        // TODO: Perform any additional validation if needed

        // Perform the delete query
        $deleteQuery = $conn->prepare("DELETE FROM orders WHERE id = :orderId");
        $deleteQuery->bindParam(':orderId', $orderId);

        if ($deleteQuery->execute()) {
            // Redirect back to the cart page or any other page
            header("Location: cart.php");
            exit();
        } else {
            echo 'Failed to delete order';
        }
    } else {
        echo 'Invalid order ID';
    }
} else {
    echo 'Invalid request method';
}
?>
