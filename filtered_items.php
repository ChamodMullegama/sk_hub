<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
<?php

include './db.php';

// Create a new instance of the connection class
$db = new connection();
$conn = $db->getConnection();
// Retrieve data from the database
$stmt = $conn->prepare("SELECT * FROM clothing_items");
$stmt->execute();

// Set default values for category, subcategory, and item name
$category = '';
$subCategory = '';
$itemName = '';

// Check if the category parameter is set in the URL
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

// Check if the subcategory parameter is set in the URL
if (isset($_GET['sub_category'])) {
    $subCategory = $_GET['sub_category'];
}

// Check if the item name parameter is set in the URL
if (isset($_GET['itemName'])) {
    $itemName = '%' . $_GET['itemName'] . '%';
}

// Use a prepared statement to prevent SQL injection
if (!empty($category) && !empty($subCategory) && !empty($itemName)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE category = :category 
                            AND sub_category = :subCategory 
                            AND productName LIKE :itemName");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':subCategory', $subCategory, PDO::PARAM_STR);
    $stmt->bindParam(':itemName', $itemName, PDO::PARAM_STR);
} elseif (!empty($category) && !empty($subCategory)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE category = :category 
                            AND sub_category = :subCategory");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':subCategory', $subCategory, PDO::PARAM_STR);
} elseif (!empty($category) && !empty($itemName)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE category = :category 
                            AND productName LIKE :itemName");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':itemName', $itemName, PDO::PARAM_STR);
} elseif (!empty($subCategory) && !empty($itemName)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE sub_category = :subCategory 
                            AND productName LIKE :itemName");
    $stmt->bindParam(':subCategory', $subCategory, PDO::PARAM_STR);
    $stmt->bindParam(':itemName', $itemName, PDO::PARAM_STR);
} elseif (!empty($category)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE category = :category");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
} elseif (!empty($subCategory)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE sub_category = :subCategory");
    $stmt->bindParam(':subCategory', $subCategory, PDO::PARAM_STR);
} elseif (!empty($itemName)) {
    $stmt = $conn->prepare("SELECT * FROM clothing_items 
                            WHERE productName LIKE :itemName");
    $stmt->bindParam(':itemName', $itemName, PDO::PARAM_STR);
} else {
    // If neither category, subcategory, nor item name is specified, retrieve all data
    $stmt = $conn->prepare("SELECT * FROM clothing_items");
}

$stmt->execute();

// Fetch all rows as an associative array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Display the table with filtered results -->
       
<h2>Clothing Items</h2>     
<!-- Add this code above the table, below the category filter form -->
<form action="filtered_items.php" method="get">
    <label for="category">Filter by Category:</label>
    <select id="category" name="category" >
    <option value="" selected disabled>Select Category</option>
    <?php
    // Assuming $conn is your database connection object
    $stmt_categories = $conn->prepare("SELECT category_name FROM category");
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        echo '<option value="' . $category['category_name'] . '">' . $category['category_name'] . '</option>';
    }
    ?>
</select>
<label for="sub_category">Sub Category/Type:</label>
<select id="sub_category" name="sub_category" >
<option value="" selected disabled>Select Sub Category</option>
    <?php
    // Assuming $conn is your database connection object
    $stmt_categories = $conn->prepare("SELECT sub_category_name FROM category");
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        echo '<option value="' . $category['sub_category_name'] . '">' . $category['sub_category_name'] . '</option>';
    }
    ?>
</select>

    <label for="itemName">Search by Item Name:</label>
    <input type="text" id="itemName" name="itemName" placeholder="Enter item name">
    <button type="submit">Apply Filter</button>
    <button type="button" id="clearBtn">Clear</button>
    <script>
    // JavaScript for form submission (Optional)
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const clearBtn = document.getElementById('clearBtn');

        clearBtn.addEventListener('click', function() {
            // Reset all form fields
            form.reset();
            form.submit();
        });
        });
</script>
</form>

<?php
// Check if there are any results
if (count($result) > 0) {
    ?>
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
                    <button type="button" class="btn btn-primary update-btn" data-bs-toggle="modal" data-bs-target="#updateFormModal" data-item-id="<?= $row['id'] ?>">Update</button>
                    <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-item-id="<?= $row['id'] ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Your existing filter form -->

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <div class="ms-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <form id="deleteForm" action="delete_item.php" method="post">
                        <input type="hidden" name="item_id" value="">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listener to all delete buttons
            var deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var itemId = button.getAttribute('data-item-id');
                    // Set the item ID in the hidden input field of the form
                    document.getElementById('deleteForm').querySelector('[name="item_id"]').value = itemId;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
                            // Add click event listener to all update buttons
                            var updateButtons = document.querySelectorAll('.update-btn');
                            updateButtons.forEach(function(button) {
                                button.addEventListener('click', function() {
                                    var itemId = button.getAttribute('data-item-id');
                                    // Redirect to the update form with the corresponding item ID
                                    window.location.href = 'update_form.php?item_id=' + itemId;
                                });
                            });
                        });

    </script>

    <?php
} else {
    // Display a Bootstrap alert when no items are found
    echo '<div class="alert alert-warning" role="alert">No items found.</div>';
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
