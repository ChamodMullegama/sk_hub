<?php
include './db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    // Create a new instance of the connection class
    $db = new connection();
    $conn = $db->getConnection();

    // Get the item_id from the POST data
    $itemId = $_POST['item_id'];

    // Delete the item from the database
    $stmt = $conn->prepare("DELETE FROM clothing_items WHERE id = ?");
    $stmt->execute([$itemId]);

    $_SESSION['success'] = 'Item deleted successfully!';
    header('location: view_item.php');
    exit();
} else {
    echo "Invalid request!";
}
?>
