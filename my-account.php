<?php
session_start();
include "includes/database.php";

// 1. SIGN IN эсвэл SIGN UP хийх логик
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action_type'])) {
        // Нэвтрэх эсвэл Бүртгүүлэхэд мэдээллийг Session-д хадгална
        $_SESSION['user_name'] = trim($_POST['fullname']);
        $_SESSION['user_email'] = trim($_POST['email']);
        
        header("Location: my-account.php");
        exit();
    }
}

// 2. LOGOUT хийх логик
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    header("Location: my-account.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>My Account - ProGear Hub</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .account-wrapper {
            max-width: 480px; /* Ганц картын өргөнд тохируулан багасгав */
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Табын товчлууруудын загвар */
        .tab-buttons {
            display: flex;
            background-color: #f1f3f5;
            padding: 4px;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .tab-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            font-weight: bold;
            color: #6c757d;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            background: #ffffff;
            color: #0b2650;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Алийг нь харуулах/нуухыг тохируулах */
        .auth-box {
            display: none;
            padding: 10px 0;
        }

        .auth-box.active {
            display: block;
        }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        .form-group input { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }

        .auth-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            margin-top: 10px;
        }

        .btn-login { background: #0b2650; }
        .btn-signup { background: #28a745; }
        .btn-login:hover { background: #081b3a; }
        .btn-signup:hover { background: #218838; }

        /* Профайл харуулах хэсэг */
        .profile-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #0b2650;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 15px;
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .account-links {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .account-links a {
            color: #0b2650;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<main class="account-wrapper">

    <?php if (isset($_SESSION['user_name'])): ?>
        <h2><i class="fa-solid fa-circle-user"></i> My Account</h2>
        <br>
        
        <div class="account-links">
            <a href="orders.php"><i class="fa-solid fa-box"></i> My Orders</a> | 
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> My Cart</a>
        </div>

        <div class="profile-card">
            <h3>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h3>
            <br>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <p><strong>Status:</strong> Active Member</p>
            
            <a href="my-account.php?action=logout" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out / Logout
            </a>
        </div>

    <?php else: ?>
        <h2>Account Login / Register</h2>
        <p>Please sign in or create an account to manage your orders.</p>

        <div class="tab-buttons">
            <button type="button" id="signInTab" class="tab-btn active" onclick="switchForm('signin')">Sign In</button>
            <button type="button" id="signUpTab" class="tab-btn" onclick="switchForm('signup')">Sign Up</button>
        </div>

        <div class="auth-container">
            
            <div id="signInBox" class="auth-box active">
                <form action="my-account.php" method="POST">
                    <input type="hidden" name="action_type" value="login">
                    
                    <div class="form-group">
                        <label>Your Name:</label>
                        <input type="text" name="fullname" required placeholder="Нэрээ оруулна уу">
                    </div>

                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="email" name="email" required placeholder="И-мэйл хаяг">
                    </div>

                    <button type="submit" class="auth-btn btn-login">Sign In</button>
                </form>
            </div>

            <div id="signUpBox" class="auth-box">
                <form action="my-account.php" method="POST">
                    <input type="hidden" name="action_type" value="register">

                    <div class="form-group">
                        <label>Full Name:</label>
                        <input type="text" name="fullname" required placeholder="Бүтэн нэр">
                    </div>

                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="email" name="email" required placeholder="И-мэйл хаяг">
                    </div>

                    <button type="submit" class="auth-btn btn-signup">Create Account</button>
                </form>
            </div>

        </div>
    <?php endif; ?>

    <br><br>
    <a href="index.php" style="color: #666; text-decoration: none;">← Back to Shop</a>
</main>

<script>
    function switchForm(type) {
        const signInBox = document.getElementById('signInBox');
        const signUpBox = document.getElementById('signUpBox');
        const signInTab = document.getElementById('signInTab');
        const signUpTab = document.getElementById('signUpTab');

        if (type === 'signin') {
            signInBox.classList.add('active');
            signUpBox.classList.remove('active');
            signInTab.classList.add('active');
            signUpTab.classList.remove('active');
        } else {
            signUpBox.classList.add('active');
            signInBox.classList.remove('active');
            signUpTab.classList.add('active');
            signInTab.classList.remove('active');
        }
    }
</script>

</body>
</html>