<?php
include_once("./hub.php");
include_once("./db.php");

$db = new connection();
$conn = $db->getConnection();

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId > 0) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items WHERE id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($productDetails) {
        // Display product details here
        echo '<h1>' . $productDetails['productName'] . '</h1>';
        echo '<p>Category: ' . $productDetails['category'] . '</p>';
        // Add more details as needed

    } else {
        echo 'Product not found';
    }
} else {
    echo 'Invalid product ID';
}
?>
