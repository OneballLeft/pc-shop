<?php
$page_title = 'Dashboard';
require_once 'includes/header.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$user = getCurrentUser();
$user_id = $_SESSION['user_id'];

// Get user statistics
$cart_count_query = "SELECT COUNT(*) as count FROM cart WHERE user_id = $user_id";
$cart_count_result = mysqli_query($conn, $cart_count_query);
$cart_count = mysqli_fetch_assoc($cart_count_result)['count'];

$orders_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$orders_result = mysqli_query($conn, $orders_query);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

$total_orders_query = "SELECT COUNT(*) as count, COALESCE(SUM(total_amount), 0) as total_spent FROM orders WHERE user_id = $user_id";
$total_orders_result = mysqli_query($conn, $total_orders_query);
$total_orders_data = mysqli_fetch_assoc($total_orders_result);
$total_orders = $total_orders_data['count'];
$total_spent = $total_orders_data['total_spent'];
?>

<div class="container">
    <h1 class="section-title">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>

    <!-- Dashboard Stats -->
    <div class="dashboard-grid fade-in">
        <div class="dashboard-card">
            <h3>Cart Items</h3>
            <div class="number"><?php echo $cart_count; ?></div>
            <a href="cart.php" class="btn btn-outline" style="margin-top: 1rem;">View Cart</a>
        </div>

        <div class="dashboard-card">
            <h3>Total Orders</h3>
            <div class="number"><?php echo $total_orders; ?></div>
        </div>

        <div class="dashboard-card">
            <h3>Total Spent</h3>
            <div class="number">$<?php echo number_format($total_spent, 2); ?></div>
        </div>

        <div class="dashboard-card">
            <h3>Member Since</h3>
            <div style="font-size: 1.2rem; color: var(--secondary-color); margin-top: 1rem;">
                <?php echo date('M Y', strtotime($user['created_at'])); ?>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <section class="section">
        <h2 class="section-title">Account Information</h2>
        <div style="background: var(--bg-light); padding: 2rem; border-radius: 12px; max-width: 600px; margin: 0 auto;" class="fade-in">
            <div style="margin-bottom: 1.5rem;">
                <strong>Full Name:</strong>
                <p style="color: var(--text-light); margin-top: 0.5rem;"><?php echo htmlspecialchars($user['full_name']); ?></p>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <strong>Username:</strong>
                <p style="color: var(--text-light); margin-top: 0.5rem;"><?php echo htmlspecialchars($user['username']); ?></p>
            </div>
            <div>
                <strong>Email:</strong>
                <p style="color: var(--text-light); margin-top: 0.5rem;"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
    </section>

    <!-- Recent Orders -->
    <section class="section">
        <h2 class="section-title">Recent Orders</h2>
        <?php if (empty($orders)): ?>
            <p style="text-align: center; color: var(--text-light);">You haven't placed any orders yet.</p>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="products.php" class="btn btn-secondary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div style="max-width: 800px; margin: 0 auto;" class="fade-in">
                <?php foreach ($orders as $order): ?>
                <div style="background: var(--bg-color); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 12px; margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>Order #<?php echo $order['id']; ?></strong>
                            <p style="color: var(--text-light); margin-top: 0.5rem;">
                                <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: var(--secondary-color);">
                                $<?php echo number_format($order['total_amount'], 2); ?>
                            </div>
                            <span style="display: inline-block; margin-top: 0.5rem; padding: 0.3rem 0.8rem; background: var(--bg-light); border-radius: 20px; font-size: 0.85rem;">
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Quick Actions -->
    <section class="section">
        <h2 class="section-title">Quick Actions</h2>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;" class="fade-in">
            <a href="products.php" class="btn btn-secondary">Browse Products</a>
            <a href="cart.php" class="btn btn-outline">View Cart</a>
            <a href="contact.php" class="btn btn-outline">Contact Support</a>
        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>
