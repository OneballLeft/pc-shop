<?php
$page_title = 'Home';
require_once 'src/includes/header.php';

// Fetch featured products
$query = 'SELECT * FROM products WHERE featured = TRUE ORDER BY created_at DESC LIMIT 4';
$result = mysqli_query($conn, $query);
$featured_products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container">
    <!-- Hero Section -->
    <section class="hero fade-in">
        <h1>Build Your Dream PC</h1>
        <p>High-performance custom computers tailored to your needs</p>
        <a href="src/products.php" class="btn">Explore Our Collection</a>
    </section>

    <!-- Featured Products Section -->
    <section class="section">
        <h2 class="section-title">Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
            <div class="product-card fade-in">
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <span class="product-category"><?php echo htmlspecialchars($product['category']); ?></span>
                    <p class="product-description">
                        <?php echo htmlspecialchars(substr($product['description'], 0, 80)) . '...'; ?>
                    </p>
                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                    <div class="product-actions">
                        <a href="src/product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section">
        <h2 class="section-title">Why Choose TechPC?</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card fade-in">
                <h3>Premium Components</h3>
                <p>We use only the highest quality parts from trusted manufacturers</p>
            </div>
            <div class="dashboard-card fade-in">
                <h3>Expert Assembly</h3>
                <p>Each PC is carefully built and tested by experienced technicians</p>
            </div>
            <div class="dashboard-card fade-in">
                <h3>Warranty Support</h3>
                <p>All systems come with comprehensive warranty and technical support</p>
            </div>
            <div class="dashboard-card fade-in">
                <h3>Fast Shipping</h3>
                <p>Quick and secure delivery to your doorstep</p>
            </div>
        </div>
    </section>
</div>

<?php require_once 'src/includes/footer.php'; ?>
