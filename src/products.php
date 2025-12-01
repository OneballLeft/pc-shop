<?php
$page_title = 'Products';
require_once 'includes/header.php';

// Get category filter if provided
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Build query
$query = "SELECT * FROM products";
if ($category) {
    $query .= " WHERE category = '" . mysqli_real_escape_string($conn, $category) . "'";
}
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get all categories for filter
$cat_query = "SELECT DISTINCT category FROM products ORDER BY category";
$cat_result = mysqli_query($conn, $cat_query);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
?>

<div class="container">
    <h1 class="section-title">Our Products</h1>

    <!-- Category Filter -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="products.php" class="btn <?php echo !$category ? 'btn-secondary' : 'btn-outline'; ?>" style="margin: 0.5rem;">All</a>
        <?php foreach ($categories as $cat): ?>
        <a href="products.php?category=<?php echo urlencode($cat['category']); ?>"
           class="btn <?php echo $category == $cat['category'] ? 'btn-secondary' : 'btn-outline'; ?>"
           style="margin: 0.5rem;">
            <?php echo htmlspecialchars($cat['category']); ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p style="text-align: center; grid-column: 1 / -1;">No products found in this category.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card fade-in">
                <div class="product-image">
                    <span>&#128421;</span>
                </div>
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <span class="product-category"><?php echo htmlspecialchars($product['category']); ?></span>
                    <p class="product-description">
                        <?php echo htmlspecialchars(substr($product['description'], 0, 80)) . '...'; ?>
                    </p>
                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                    <div style="margin-bottom: 0.5rem; color: var(--text-light);">
                        Stock: <?php echo $product['stock'] > 0 ? $product['stock'] . ' available' : 'Out of stock'; ?>
                    </div>
                    <div class="product-actions">
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
