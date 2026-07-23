<?php
session_start();
include "includes/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ProGear Hub</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<header>

    <div class="top-header">

       <a href="index.php" class="logo-link">
        <img src="logo.png" alt="ProGear Hub logo" class="main-logo">
       </a>

        <form class="search-container" action="search.php" method="GET">
            <input type="text"
                   class="search-input"
                   placeholder="Search Products..."
                   name="q"
                   required>

            <button type="submit" class="search-btn">
                <img src="10629681.png"
                     alt="Search"
                     class="search-icon">
            </button>
        </form>

        <div class="user-menu">

            <a href="my-account.php" class="icon-item">
                <i class="fa-regular fa-user"></i>
                <span>My Account</span>
            </a>

            <a href="my-account.php" class="icon-item">
                <i class="fa-solid fa-user-plus"></i>
                <span>Join Us</span>
            </a>

            <a href="help.php" class="icon-item">
                <i class="fa-regular fa-circle-question"></i>
                <span>Help</span>
            </a>

            <a href="cart.php" class="cart-btn">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count">
                    <?php 
                        $total_count = 0;
                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            $total_count = array_sum($_SESSION['cart']);
                        }
                        echo $total_count;
                    ?>
                </span>
                <span>Cart</span>
            </a>

        </div>

    </div>

    <nav>
        <a href="index.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="orders.php">Orders</a>
        <a href="about.php">About Us</a>
        <a href="blog.php">Blog</a>
        <a href="contact.php">Contact</a>
    </nav>

    <nav class="category-nav">
        <a href="Football.php" class="nav-item"><img src="soccer.png" class="nav-icon" alt="Football">Football</a>
        <a href="Basketball.php" class="nav-item"><img src="basketball.png" class="nav-icon" alt="Basketball">Basketball</a>
        <a href="Cricket.php" class="nav-item"><img src="cricket.png" class="nav-icon" alt="Cricket">Cricket</a>
        <a href="Tennis.php" class="nav-item"><img src="tennis.png" class="nav-icon" alt="Tennis">Tennis</a>
        <a href="Swimming.php" class="nav-item"><img src="goggles.png" class="nav-icon" alt="Swimming">Swimming</a>
        <a href="Accessories.php" class="nav-item"><img src="gym.png" class="nav-icon" alt="Accessories">Accessories</a>
        <a href="Sales.php" class="Sale">Sales Now on</a>
    </nav>

</header>

<main class="content"> 
    <div class="products"> 
        <?php
        $query = "SELECT id, name, brand, image, description, price FROM productdata";
        $statement = $connection->prepare($query);
        $statement->execute();
        $products = array();
        $result = $statement->get_result();
        
        while($row = $result->fetch_assoc()){
            array_push($products, $row);
        }
        
        foreach($products as $item){
            $id = $item['id'];
            $name = $item['name'];
            $brand = $item['brand'];
            $image = $item['image'];

            echo "<div class='card'>
                    <a href='detail.php?id=$id' class='product-link'>
                        <img class='product-image' src='ProductImages/$image'>
                        <h4 class='product-name'>$name</h4>
                    </a>
                    <p class='product-brand'>$brand</p>
                  </div>";
        }
        ?>
    </div>
</main>

<section class="hero">
    <h2>Featured Sports Products</h2>
    <p>Seasonal sales and new arrivals</p>
</section>

<footer>
    <p>© 2026 ProGear Hub</p>
</footer>

</body>
</html>