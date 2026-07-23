<?php
session_start();
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>My Orders - ProGear Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .orders-container { max-width: 800px; margin: 40px auto; padding: 20px; }
        .order-card { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .order-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px; font-weight: bold; }
        .item-row { display: flex; align-items: center; gap: 15px; margin: 10px 0; }
        .item-row img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        .status-badge { background: #28a745; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>

<main class="orders-container">
    <h2><i class="fa-solid fa-box"></i> My Orders</h2>
    <br>

    <?php if (isset($_SESSION['my_orders']) && !empty($_SESSION['my_orders'])): ?>
        <?php foreach (array_reverse($_SESSION['my_orders']) as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span>Order ID: <?php echo $order['order_id']; ?></span>
                    <span class="status-badge">Processing</span>
                </div>
                <p><small>Date: <?php echo $order['date']; ?></small></p>
                <p><strong>Deliver to:</strong> <?php echo $order['name']; ?> (<?php echo $order['phone']; ?>) - <?php echo $order['address']; ?></p>
                <hr>
                
                <?php foreach ($order['items'] as $item): ?>
                    <div class="item-row">
                        <img src="ProductImages/<?php echo $item['image']; ?>">
                        <div>
                            <strong><?php echo $item['name']; ?></strong><br>
                            $<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <h4 style="text-align: right;">Total Paid: $<?php echo number_format($order['total'], 2); ?></h4>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Танд одоогоор хийсэн захиалга байхгүй байна. <a href="index.php">Shop руу очих</a></p>
    <?php endif; ?>
</main>

</body>
</html>