<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <h2>Add Category</h2>
    <form action="process.php" method="post">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" required><br>

        <label for="sub_category_name">Sub-Category Name:</label>
        <input type="text" name="sub_category_name" required><br>

        <label for="description">Description:</label>
        <textarea name="description"></textarea><br>

        <input type="submit" value="Add Category">
    </form>
</body>
</html>
