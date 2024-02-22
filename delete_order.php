<?php
include_once("connection.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = 'DELETE FROM products WHERE id=:cid';
    $deleteStatement = $conn->prepare($sql);

    if ($deleteStatement->execute(['cid' => $id])) {
        echo "<script>
                alert('Item deleted successfully.');
                window.location.href = 'seller.php';
              </script>";
        exit(); // Ensure no further execution after redirection
    } else {
        // Handle delete failure
        echo "Error deleting item: " . $deleteStatement->errorInfo()[2];
    }
} else {
    // Handle invalid or missing id parameter
    echo "Invalid or missing item ID";
}
?>
