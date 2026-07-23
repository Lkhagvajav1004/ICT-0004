<?php
session_start();
include "includes/database.php";

// Сагс хоосон байвал буцаах
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Захиалга илгээх үед
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    
    $order_items = array();
    $grand_total = 0;

    foreach ($_SESSION['cart'] as $p_id => $qty) {
        $query = "SELECT * FROM productdata WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $p_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            $price = isset($res['price']) ? $res['price'] : 25;
            $subtotal = $price * $qty;
            $grand_total += $subtotal;

            $order_items[] = array(
                'name' => $res['name'],
                'image' => $res['image'],
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal
            );
        }
    }

    $new_order = array(
        'order_id' => 'PGH-' . rand(1000, 9999),
        'name' => $_POST['fullname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'items' => $order_items,
        'total' => $grand_total,
        'date' => date('Y-m-d H:i:s')
    );

    if (!isset($_SESSION['my_orders'])) {
        $_SESSION['my_orders'] = array();
    }
    
    $_SESSION['my_orders'][] = $new_order;
    unset($_SESSION['cart']);

    header("Location: orders.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Checkout - ProGear Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .checkout-box { max-width: 500px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .submit-btn { width: 100%; background: #28a745; color: white; border: none; padding: 12px; font-size: 16px; font-weight: bold; border-radius: 6px; cursor: pointer; }
        .submit-btn:hover { background: #218838; }
    </style>
</head>
<body>

<main class="checkout-box">
    <h2>Checkout Information</h2>
    <br>
    <form action="checkout.php" method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="fullname" required placeholder="Нэрээ оруулна уу">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="И-мэйл хаяг">
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" required placeholder="Утасны дугаар">
        </div>

        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" rows="3" required placeholder="Хүргэлтийн хаяг"></textarea>
        </div>

        <button type="submit" name="place_order" class="submit-btn">Submit / Place Order</button>
    </form>
</main>

</body>
</html>