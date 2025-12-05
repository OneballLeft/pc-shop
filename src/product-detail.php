<?php
require_once 'includes/header.php';

// Get product ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id === 0) {
    redirect('products.php');
}

// Fetch product details
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    redirect('products.php');
}

$page_title = $product['name'];

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isLoggedIn()) {
        redirect('login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    }

    $user_id = $_SESSION['user_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Check if product already in cart
    $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update quantity
        $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new cart item
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        mysqli_query($conn, $insert_query);
    }

    $success_message = "Product added to cart!";
}
?>

<div class="container">
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <div class="product-detail fade-in">
        <div class="product-detail-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <span class="product-category"><?php echo htmlspecialchars($product['category']); ?></span>

            <div class="product-price" style="margin: 1rem 0;">
                $<?php echo number_format($product['price'], 2); ?>
            </div>

            <p style="color: var(--text-light); margin-bottom: 1.5rem;">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>

            <div class="product-detail-specs">
                <h3>Specifications</h3>
                <p><?php echo nl2br(htmlspecialchars($product['specifications'])); ?></p>
            </div>

            <div style="margin-bottom: 1rem;">
                <strong>Availability:</strong>
                <?php if ($product['stock'] > 0): ?>
                    <span style="color: green;"><?php echo $product['stock']; ?> in stock</span>
                <?php else: ?>
                    <span style="color: red;">Out of stock</span>
                <?php endif; ?>
            </div>

            <?php if ($product['stock'] > 0): ?>
            <form method="POST" style="margin-top: 1.5rem;">
                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width: 100px;">
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-secondary" style="width: 100%;">
                    Add to Cart
                </button>
            </form>
            <?php endif; ?>

            <a href="products.php" class="btn btn-outline" style="width: 100%; margin-top: 1rem;">
                Back to Products
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
