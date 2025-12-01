<?php
// Database configuration
// Use environment variables if available (for production), otherwise use defaults (for local dev)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'pc_user');
define('DB_PASS', getenv('DB_PASS') ?: 'arch');
define('DB_NAME', getenv('DB_NAME') ?: 'pc_store');

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Helper function to get current user
function getCurrentUser()
{
    global $conn;
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    return null;
}

// Helper function to redirect
function redirect($url)
{
    header("Location: $url");
    exit();
}
?>
