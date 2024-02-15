<?php
include_once("./header_HOME.php");
include_once("./db.php");

$connection = new connection();
$conn = $connection->getConnection();

$sql = "SELECT category_name, GROUP_CONCAT(sub_category_name) AS sub_categories 
        FROM category 
        GROUP BY category_name";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selectedCategory = isset($_GET['category']) ? urldecode($_GET['category']) : null;
$selectedSubCategory = isset($_GET['sub_category']) ? urldecode($_GET['sub_category']) : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/nav_bar_bw.css">
    <script src="./"></script>
    <style>
        /* Add this to your existing CSS file or create a new one */
        .category-link {
            position: relative;
            display: inline-block;
        }

        .sub-category-links {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 200px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .category-link:hover .sub-category-links {
            display: block;
        }
    </style>
    
</head>
<body>
    <div class="navbar2">
        <a href="#home">Home</a>
        <a href="#news">News</a>
        <div class="dropdown2">
            <button class="dropbtn2">Dropdown 
            <i class="fa fa-caret-down"></i>
            </button>
<!-- Modify the category links to include the category and sub-category parameters in the URL -->

<div class="dropdown2-content2">
    <?php
    foreach ($categories as $category) {
        $categoryName = urlencode($category['category_name']);
        echo "<div class='category-link'>";
        echo "<a href='./category.php?category={$categoryName}'>{$category['category_name']}</a>";

        // Check if there are sub-categories
        if (!empty($category['sub_categories'])) {
            $subCategories = explode(",", $category['sub_categories']);
            echo "<div class='sub-category-links'>";
            foreach ($subCategories as $subCategory) {
                $subCategoryName = urlencode(trim($subCategory));
                echo "<a href='./category.php?category={$categoryName}&sub_category={$subCategoryName}'>{$subCategory}</a>";
            }
            echo "</div>";
        }

        echo "</div>";
    }
    ?>
</div>
</div>




            </div>
        </div> 
    </div>

    <script>
   function filterItems(category, subCategory) {
    // Prevent the default form submission behavior
    event.preventDefault();

    document.getElementById('category').value = category;
    document.getElementById('sub_category').value = subCategory;
    document.getElementById('filterForm').submit();
}

</script>
</body>
</html>

<?php
include_once("./footer.php");
?>
