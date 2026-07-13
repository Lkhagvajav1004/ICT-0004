<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ProGear Hub</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<header>

    <div class="top-header">

       <a href="index.html" class="logo-link">
        <img src="logo.png" alt="ProGear Hub logo" class="main-logo">
       </a>

        <form class="search-container" action="/search" method="GET">
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

            <a href="account.html" class="icon-item">
                <i class="fa-regular fa-user"></i>
                <span>My Account</span>
            </a>

            <a href="joinus.html" class="icon-item">
                <i class="fa-solid fa-user-plus"></i>
                <span>Join Us</span>
            </a>

            <a href="help.html" class="icon-item">
                <i class="fa-regular fa-circle-question"></i>
                <span>Help</span>
            </a>

            <a href="cart.html" class="cart-btn">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count">0</span>
                <span>Cart</span>
            </a>

        </div>

    </div>

    <nav>
        <a href="index.html">Home</a>
        <a href="shop.html">Shop</a>
        <a href="orders.html">Orders</a>
        <a href="about.html">About Us</a>
        <a href="blog.html">Blog</a>
        <a href="contact.html">Contact</a>
    </nav>

    <nav class="category-nav">
        <a href="Football.html" class="nav-item"><img src="soccer.png" class="nav-icon" alt="Football">Football</a>
        <a href="Basketball.html" class="nav-item"><img src="basketball.png" class="nav-icon">Basketball</a>
        <a href="Cricket.html" class="nav-item"><img src="cricket.png" class="nav-icon">Cricket</a>
        <a href="Tennis.html" class="nav-item"><img src="tennis.png" class="nav-icon">Tennis</a>
        <a href="Swimming.html" class="nav-item"><img src="goggles.png" class="nav-icon">Swimming</a>
        <a href="Accessories.html" class="nav-item"><img src="gym.png" class="nav-icon">Accessories</a>
        <a href="Sales.html" class="Sale">Sales Now on</a>

    </nav>


</header>
 <main class="content"> 
        <div class="products"> 
            <?php
            $query = "SELECT id,name,brand,image FROM productdata";
            //statement
            $statement = $connection->prepare($query);
            $statement -> execute();
            $products = array();
            $result = $statement -> get_result();
            while($row = $result -> fetch_assoc()){
                array_push( $products, $row);
                            }
                            //output products into page as html
                            foreach($products as $item){
                                $id = $item['id'];
                                $name = $item['name'];
                                $brand = $item['brand'];
                                $image = $item['image'];

                                echo "<div class='card'>
                                <h4>$name</h4>
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
