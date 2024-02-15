<?php
include_once("./hub.php");

$selectedCategory = isset($_GET['category']) ? urldecode($_GET['category']) : null;
$selectedSubCategory = isset($_GET['sub_category']) ? urldecode($_GET['sub_category']) : null;

$sql = "SELECT id, productName, price, images FROM clothing_items WHERE ";

if ($selectedSubCategory) {
    $sql .= "sub_category LIKE :sub_category";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':sub_category', "%$selectedSubCategory%", PDO::PARAM_STR);
} elseif ($selectedCategory) {
    $sql .= "category = :category";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $selectedCategory);
} else {
    $stmt = $conn->query("SELECT id, productName, price, images FROM clothing_items");
}

// Execute the query and fetch results
$stmt->execute();
$clothingItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<title>Document</title>
    <style>
        .container {
            min-height: 100vh;
            padding: 10px;
            font-family: 'Times New Roman', Times, serif;
            margin-top: 100px;
        }

        .product {
            text-align: center;
            padding: 20px;
            background-color:white;
            transition: transform 0.3s ease;
            width: 300px;
            position: relative;
            margin-bottom: 20px; 
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .p_image {
    max-width: 90%;
    height: 200px; /* Set a fixed height for all images */
    object-fit: cover; /* Ensure images maintain aspect ratio and cover the entire container */
}


        .name {
            margin-top: 10px;
            font-size: 20px;
            font-size: medium;
            color: #333;
        }
        h3 {
           font-size: 16px; 
           color: #666; 
           margin-top: 5px; 
      }


        .price {
            color: #f30707;
            font-weight: bold;
            font-size: medium;
            margin-top: 5px;
        }

        
        .add-to-cart {
            background-color:#ed2353;
            color: #fff;
            border: none;
            border-radius: 20px;
            width: 50%;
            height: 20px;
            padding: 10px;
            padding-bottom: 30px;
            margin-top: 10px;
            cursor: pointer;
            font-family: 'Times New Roman', Times, serif;
            font-size: small;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .add-to-cart:hover {
            background-color: #ed2353;
        }

        .add-to-cart span {
            transition: opacity 0.3s ease;
        }

        .add-to-cart i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .add-to-cart:hover span {
            opacity: 0;
        }

        .add-to-cart:hover i {
            opacity: 1;
        }

        .icons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: none;
        }

        .product:hover .icons {
            display: block;
        }

        .icons i {
            margin-right: 10px;
            font-size: 24px;
        }
        
        @media (max-width: 576px) { 
            .product {
                width: 100%;
            }
        }

        .selected-categories {
    text-align: center;
    margin-bottom: 20px;
}

.selected-categories span {
    margin-right: 10px;
    padding: 5px;
    background-color: #f2f2f2;
    border: 1px solid #ddd;
}

    </style>


</head>
<body>



<div class="container">

<div class="selected-categories">
    <?php
    
    $displayedCategories = false;

    if ($selectedCategory || $selectedSubCategory) {
        echo "<div class='selected-categories'>";
        
        if ($selectedCategory) {
            echo "<span>{$selectedCategory}</span>";
            $displayedCategories = true;
        }
        
        if ($selectedSubCategory) {
            if ($displayedCategories) {
                echo " -> ";
            }
            echo "<span>{$selectedSubCategory}</span>";
        }
    
        echo "</div>";
    }
    ?>
</div>

    <div class="row">
        <?php foreach ($clothingItems as $item): ?>
            <div class="col-lg-3">
                <div class="product">
                <?php
            $images = explode(',', $item['images']);
            if (!empty($images)) {
                ?>
                <img class="p_image" src="<?php echo $images[0]; ?>" alt="<?php echo $item['productName']; ?>">
                <?php
            }
            ?>   



                    <h2 class="name"><?php echo $item['productName']; ?></h2>
                    <p class="price">Rs<?php echo $item['price']; ?></p>
                    <h3>or 3 x Rs700.00 with <a href="https://mintpay.lk/"><img src="WhatsApp Image 2024-02-10 at 07.34.45_6a6b3619.jpg" alt="" height="20px" width="60px"></a><br> or x Rs700.00 with <a href="https://paykoko.com/"><img src="WhatsApp Image 2024-02-10 at 07.34.51_b0ba59c6.jpg" alt="" height="40px" width="60px"></a></h3>
                    <form method="get" action="item_details.php" >
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="add-to-cart">VIEW DETAILS</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>