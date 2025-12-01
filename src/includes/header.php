<?php
require_once __DIR__ . '/config.php';
$current_page = basename($_SERVER['PHP_SELF']);
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>TechPC Store</title>
    <link rel="stylesheet" href="/src/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="/index.php">TechPC</a>
                </div>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="/index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="/src/products.php" class="<?php echo $current_page == 'products.php' ? 'active' : ''; ?>">Products</a></li>
                    <li><a href="/src/about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
                    <li><a href="/src/contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="/src/dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                        <li><a href="/src/cart.php" class="<?php echo $current_page == 'cart.php' ? 'active' : ''; ?>">Cart</a></li>
                        <li><a href="/src/logout.php" class="btn-logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/src/login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">Login</a></li>
                        <li><a href="/src/register.php" class="btn-primary"><?php echo $current_page == 'register.php' ? 'Register' : 'Sign Up'; ?></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
