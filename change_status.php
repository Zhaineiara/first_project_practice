<?php
// change_status.php

try {
    if (isset($_GET['receipt_id'])) {
        $receiptId = $_GET['receipt_id'];

        //database connection
        include_once("connection.php");

        // Fetch the current status from the receipt table
        $getStatusQuery = $conn->prepare("SELECT status FROM receipt WHERE id = :receipt_id");
        $getStatusQuery->bindParam(':receipt_id', $receiptId);
        $getStatusQuery->execute();
        $currentStatus = $getStatusQuery->fetchColumn();

        // Toggle between "Complete" and "Incomplete"
        $newStatus = ($currentStatus == 'Complete') ? 'Incomplete' : 'Complete';

        // Update the status in the receipt table
        $updateStatusQuery = $conn->prepare("UPDATE receipt SET status = :new_status WHERE id = :receipt_id");
        $updateStatusQuery->bindParam(':receipt_id', $receiptId);
        $updateStatusQuery->bindParam(':new_status', $newStatus);

        if ($updateStatusQuery->execute()) {
            echo 'success';
        } else {
            echo 'error_database_execution';
        }
    } else {
        echo 'invalid_request';
    }
} catch (PDOException $pdoException) {
    // Log the exception to an error log
    error_log('PDOException in change_status.php: ' . $pdoException->getMessage());

    // Close the database connection
    $conn = null;

    echo 'error_database_exception';
} catch (Exception $e) {
    // Log the exception to an error log
    error_log('Exception in change_status.php: ' . $e->getMessage());

    // Close the database connection
    $conn = null;

    echo 'error_exception';
}
?>
