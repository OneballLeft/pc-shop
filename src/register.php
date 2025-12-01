<?php
$page_title = 'Register';
require_once 'includes/header.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');

    // Validation
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($full_name)) {
        $errors[] = "Full name is required";
    }

    // Check if username or email already exists
    if (empty($errors)) {
        $username_check = mysqli_real_escape_string($conn, $username);
        $email_check = mysqli_real_escape_string($conn, $email);

        $check_query = "SELECT * FROM users WHERE username = '$username_check' OR email = '$email_check'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Username or email already exists";
        }
    }

    // Insert user if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $username_safe = mysqli_real_escape_string($conn, $username);
        $email_safe = mysqli_real_escape_string($conn, $email);
        $full_name_safe = mysqli_real_escape_string($conn, $full_name);

        $insert_query = "INSERT INTO users (username, email, password, full_name)
                        VALUES ('$username_safe', '$email_safe', '$hashed_password', '$full_name_safe')";

        if (mysqli_query($conn, $insert_query)) {
            $success = true;
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="container">
    <div class="form-container fade-in">
        <h2 style="text-align: center; margin-bottom: 2rem;">Create Account</h2>

        <?php if ($success): ?>
            <div class="alert alert-success">
                Registration successful! You can now <a href="login.php">login</a>.
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-secondary" style="width: 100%;">Register</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
