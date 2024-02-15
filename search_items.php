<?php

include './db.php';

// Create a new instance of the connection class
$db = new connection();
$conn = $db->getConnection();

// Check if the search parameter is set in the URL
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE productName LIKE :search 
                               OR category LIKE :search 
                               OR sub_category LIKE :search 
                               OR brand LIKE :search 
                               OR material LIKE :search 
                               OR tags LIKE :search 
                               OR availabilityStatus LIKE :search");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no search parameter is set, retrieve all data
    $stmt = $conn->prepare("SELECT * FROM clothing_items");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Display the table with search results -->

<table border="1">
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Sub Category</th>
        <th>Brand</th>
        <th>Size Options</th>
        <th>Material</th>
        <th>Price</th>
        <th>Quantity Available</th>
        <th>Description</th>
        <th>Care Instructions</th>
        <th>Tags</th>
        <th>Availability Status</th>
        <th>Discounts</th>
        <th>Images</th>
        <th>Action</th>
    </tr>

    <?php foreach ($result as $row): ?>
        <tr>
            <td><?= $row['productName'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['sub_category'] ?></td>
            <td><?= $row['brand'] ?></td>
            <td><?= $row['sizeOptions'] ?></td>
            <td><?= $row['material'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['quantityAvailable'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['careInstructions'] ?></td>
            <td><?= $row['tags'] ?></td>
            <td><?= $row['availabilityStatus'] ?></td>
            <td><?= $row['discounts'] ?></td>
            <td><img src="<?= $row['images'] ?>" alt="Image"></td>
            <td>
            <a href="update_form.php?item_id=<?= $row['id'] ?>" class="update-link">Update</a>

            
            <form action="delete_item.php" method="post">
    <input type="hidden" name="item_id" value="<?= $row['id'] ?>">
    <button type="submit">Delete</button>
</form>
            
            </td>
        </tr>
    <?php endforeach; ?>
</table>
