<?php
session_start();
include "includes/database.php";

// "Add to Cart" дарагдахад
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Амжилттай нэмэгдсэнийг мэдээлэх параметр дагуулж үсэрнэ
    header("Location: cart.php?added=success");
    exit();
}

// Устгах хэсэг
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $remove_id = $_GET['id'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ProGear Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .cart-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th, .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .cart-table th {
            background-color: #0b2650;
            color: white;
        }

        .cart-product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .cart-product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .total-price-box {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #0d47a1;
            margin-top: 15px;
        }

        .btn-remove {
            color: #e62117;
            text-decoration: none;
            font-size: 18px;
        }

        .checkout-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            float: right;
            margin-top: 15px;
            text-decoration: none;
            display: inline-block;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>

<main class="cart-container">
    <h2><i class="fa-solid fa-cart-shopping"></i> Shopping Cart</h2>
    <br>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;

                // Сагсанд байгаа ID тус бүрээр баазаас мэдээллийг олно
                foreach ($_SESSION['cart'] as $p_id => $qty) {
                    $query = "SELECT * FROM productdata WHERE id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("i", $p_id);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $item = $res->fetch_assoc();

                    if ($item) {
                        $price = isset($item['price']) ? $item['price'] : 25; // Үнэ байхгүй бол заагч 25$
                        $total = $price * $qty;
                        $grand_total += $total;
                        ?>
                        <tr>
                            <td>
                                <div class="cart-product-info">
                                    <img src="ProductImages/<?php echo $item['image']; ?>" class="cart-product-img">
                                    <span><?php echo $item['name']; ?></span>
                                </div>
                            </td>
                            <td>$<?php echo number_format($price, 2); ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>$<?php echo number_format($total, 2); ?></td>
                            <td>
                                <a href="cart.php?action=remove&id=<?php echo $p_id; ?>" class="btn-remove">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="total-price-box">
            Total Amount: $<?php echo number_format($grand_total, 2); ?>
        </div>

        <div style="overflow: hidden;">
            <a href="index.php" style="float: left; margin-top: 20px; color: #0d47a1;">← Continue Shopping</a>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <h3>Your cart is empty!</h3>
            <p>You haven't added any products to your cart yet.</p>
            <br>
            <a href="index.php" style="color: #0d47a1;">Go to Shop</a>
        </div>
    <?php endif; ?>
</main>

</body>
</html>