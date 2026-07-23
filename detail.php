<?php
include "includes/database.php";

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $query = "SELECT * FROM productdata WHERE id = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("i", $product_id);
    $statement->execute();
    $result = $statement->get_result();
    $product = $result->fetch_assoc();

    // Хэрэв ийм ID-тай бараа баазаас олдохгүй бол үндсэн хуудас руу буцаана
    if (!$product) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - ProGear Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <style>
        .detail-container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .detail-image {
            flex: 1;
        }

        .detail-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .detail-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .product-title {
            font-size: 28px;
            color: #011027;
        }

        .product-brand {
            font-size: 16px;
            color: #666;
        }

        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #0d47a1;
        }

        /* Тайлбар хэсгийн CSS */
        .product-description {
            font-size: 14px;
            color: #444;
            line-height: 1.6;
            background: #f9f9f9;
            padding: 12px;
            border-radius: 6px;
        }

        .cart-action-form {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 15px;
        }

        .quantity-input {
            width: 60px;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .add-to-cart-btn {
            background-color: #0d47a1;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #4f8be4;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            color: #0d47a1;
        }
    </style>
</head>
<body>

<main class="detail-container">
    <div class="detail-image">
        <img src="ProductImages/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>

    <div class="detail-info">
        <h1 class="product-title"><?php echo $product['name']; ?></h1>
        <p class="product-brand">Brand: <strong><?php echo $product['brand']; ?></strong></p>
        
        <div class="product-price">
            $<?php echo isset($product['price']) ? $product['price'] : '45.00'; ?>
        </div>

        <?php if (!empty($product['description'])): ?>
            <div class="product-description">
                <strong>Description:</strong>
                <p><?php echo $product['description']; ?></p>
            </div>
        <?php endif; ?>

        <form action="cart.php" method="POST" class="cart-action-form">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="quantity-input">

            <button type="submit" name="add_to_cart" class="add-to-cart-btn">
                <i class="fa-solid fa-cart-shopping"></i> Add to cart
            </button>
        </form>

        <a href="index.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</main>

</body>
</html>