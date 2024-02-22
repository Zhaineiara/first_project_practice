<?php
include_once("connection.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['cid'])) {
        $userId = $_SESSION['cid'];

        // TODO: Perform any additional validation if needed

        // Perform the delete query
        $deleteQuery = $conn->prepare("DELETE FROM orders WHERE user_id = :userId");
        $deleteQuery->bindParam(':userId', $userId);

        if ($deleteQuery->execute()) {
            // Redirect back to the cart page or any other page
            header("Location: cart.php");
            exit();
        } else {
            echo 'Failed to cancel orders';
        }
    } else {
        echo 'User not logged in';
    }
} else {
    echo 'Invalid request method';
}
?>





