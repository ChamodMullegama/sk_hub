<?php
// Automatically generated PHP file for category: new
$categoryName = 'new';
$description = 'gdsfdf';
// Include necessary files
include_once("../header_HOME.php");
include_once("../db.php");
$connection = new connection();
$conn = $connection->getConnection();
// Add your category logic here
// Fetch distinct categories and their sub-categories from the database
// ... (your existing category logic)
// Close connection
$conn = null;
include_once("../footer.php");
?>