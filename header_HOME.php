<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./IMAGES/logo/Copy of Black White Minimalist Aesthetic Letter Initial Name Monogram Logo (3).png" type="image/x-icon">
    <title>SK Fashion Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Homemade+Apple&family=Saira+Extra+Condensed:wght@100&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/nav.css">
</head>
<body>
    <div class="top">
        <div class="top-part">
            <div class="logo">
                <a href="./index.php">
                    <video width="100%" height="100%" autoplay loop muted>
                        <source src="./VIDEO/TensorPix - Copy of Black White Minimalist Aesthetic Letter Initial Name Monogram Logo (1).mp4" type="video/mp4">
                    </video>
                </a>
            </div>
            
            <div class="menu">
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="">Deals</a></li>
                    <li><a href="">SK Fashion Hub</a></li>
                    <li><a href="./BridalWear.php">SK Bridal wear</a></li>
                    <li style="float: right; margin:0; margin-right: 5%">
                        <div class="Log-in-dropdown">
                            <a href="./loginPage.php">
                                <i class="fa-solid fa-user"></i>
                            </a>

                            <div class="dropdown-content">
                                <?php
                                    session_start();

                                    if (isset($_SESSION['customer_name'])) {
                                        echo '<a href="./Profile.php">' . $_SESSION["customer_name"] . '</a>';
                                        echo '<a href="#" onclick="showLogoutConfirmation()">Logout</a>';
                                    } else {
                                        echo '<a href="./loginPage.php">Login</a>';
                                        echo '<a href="./signUpPage.php">Register</a>';
                                    }
                                ?>
                            </div>  
                        </div>
                    </li>
                    
                    <li style="float: right; margin:0; margin-right: 2%;">
                        <a href="">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </li>

                    <li style="float: right; margin:0; margin-right: 2%;">
                        <div class="search-dropdown" id="searchDropdown">
                            <a href="#" onclick="toggleSearch()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <div class="search-content" id="searchContent">
                                <form action="search.php" method="GET">
                                    <input type="text" placeholder="Search..." name="query" />
                                    <button type="submit">
                                        <i class="fa-solid fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/nav.js"></script>
</body>
</html>