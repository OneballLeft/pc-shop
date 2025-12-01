<?php
$page_title = 'Login';
require_once 'includes/header.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$redirect_url = $_GET['redirect'] ?? 'dashboard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        $username_safe = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM users WHERE username = '$username_safe' OR email = '$username_safe'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                redirect($redirect_url);
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<div class="container">
    <div class="form-container fade-in">
        <h2 style="text-align: center; margin-bottom: 2rem;">Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username or Email</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-secondary" style="width: 100%;">Login</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
