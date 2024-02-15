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
    session_start();
    // Create a new instance of the connection class
    $db = new connection();
    $conn = $db->getConnection();
    // Retrieve data from the database
    $stmt = $conn->prepare("SELECT * FROM clothing_items");
    $stmt->execute();

    // Fetch all rows as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <h2>Clothing Items</h2>

    <!-- Add this code above the table, below the category filter form -->
    <form action="filtered_items.php" method="get">
        <label for="category">Filter by Category:</label>
        <select id="category" name="category">
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
        <select id="sub_category" name="sub_category">
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
        <button type="button" onclick="clearFilters()">Clear</button>
        <script>
            function clearFilters() {
                document.getElementById("category").value = "";
                document.getElementById("sub_category").value = "";
                document.getElementById("itemName").value = "";
            }
        </script>
    </form>
    <div class="alert">
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
    </div>
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

        <?php foreach ($result as $row) : ?>
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
                    <button type="submit" name="submit" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-item-id="<?= $row['id'] ?>">Delete</button>

                    <script>
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
                    </script>

                    </form>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>



    </section>

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
</body>

</html>