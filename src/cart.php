<?php
$page_title = 'Shopping Cart';
require_once 'includes/header.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('login.php?redirect=cart.php');
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $cart_id = intval($_POST['cart_id']);
        $quantity = intval($_POST['quantity']);

        if ($quantity > 0) {
            $update_query = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id";
            mysqli_query($conn, $update_query);
            $message = "Cart updated successfully";
        }
    } elseif (isset($_POST['remove_item'])) {
        $cart_id = intval($_POST['cart_id']);
        $delete_query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $delete_query);
        $message = "Item removed from cart";
    } elseif (isset($_POST['checkout'])) {
        // Simple checkout - create order and clear cart
        $total_query = "SELECT SUM(p.price * c.quantity) as total
                       FROM cart c
                       JOIN products p ON c.product_id = p.id
                       WHERE c.user_id = $user_id";
        $total_result = mysqli_query($conn, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total = $total_row['total'] ?? 0;

        if ($total > 0) {
            $order_query = "INSERT INTO orders (user_id, total_amount) VALUES ($user_id, $total)";
            if (mysqli_query($conn, $order_query)) {
                // Clear cart
                $clear_query = "DELETE FROM cart WHERE user_id = $user_id";
                mysqli_query($conn, $clear_query);
                $message = "Order placed successfully! Total: $" . number_format($total, 2);
            }
        }
    }
}

// Fetch cart items
$cart_query = "SELECT c.*, p.name, p.price, p.stock
               FROM cart c
               JOIN products p ON c.product_id = p.id
               WHERE c.user_id = $user_id
               ORDER BY c.added_at DESC";
$cart_result = mysqli_query($conn, $cart_query);
$cart_items = mysqli_fetch_all($cart_result, MYSQLI_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="container">
    <h1 class="section-title">Shopping Cart</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <div style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 2rem;">Your cart is empty</p>
            <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="fade-in">
            <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
                <div class="cart-item-image">
                    <span style="font-size: 2rem;">&#128421;</span>
                </div>
                <div class="cart-item-details">
                    <h3 class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p class="cart-item-price">$<?php echo number_format($item['price'], 2); ?> each</p>
                    <p style="color: var(--text-light);">
                        Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                    </p>
                </div>
                <div>
                    <form method="POST" style="display: inline-block; margin-right: 0.5rem;">
                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>"
                               min="1" max="<?php echo $item['stock']; ?>"
                               style="width: 80px; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        <button type="submit" name="update_quantity" class="btn btn-outline" style="margin-left: 0.5rem;">Update</button>
                    </form>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" name="remove_item" class="btn" style="background: var(--accent-color); color: white;">Remove</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="cart-total">Total: $<?php echo number_format($total, 2); ?></div>
                <form method="POST">
                    <button type="submit" name="checkout" class="btn btn-secondary" style="width: 100%; font-size: 1.1rem;">
                        Proceed to Checkout
                    </button>
                </form>
                <a href="products.php" class="btn btn-outline" style="width: 100%; margin-top: 1rem;">
                    Continue Shopping
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
