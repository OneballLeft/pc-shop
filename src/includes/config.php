<?php
// Database configuration
// Use environment variables if available (for production), otherwise use defaults (for local dev)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'pc_user');
define('DB_PASS', getenv('DB_PASS') ?: 'arch');
define('DB_NAME', getenv('DB_NAME') ?: 'pc_store');
$use_ssl = getenv('DB_SSL') ?: 'false';

// Create database connection
if ($use_ssl === 'true') {
    // SSL connection for cloud providers like Aiven
    $conn = mysqli_init();

    // Path to CA certificate (adjust if needed)
    $ca_cert = __DIR__ . '/../../ca.pem';

    // Enable SSL with CA certificate verification
    mysqli_ssl_set($conn, NULL, NULL, $ca_cert, NULL, NULL);

    // Get port from environment or use default
    $db_port = getenv('DB_PORT') ?: 3306;

    // Connect with SSL
    mysqli_real_connect(
        $conn,
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME,
        $db_port,
        NULL,
        MYSQLI_CLIENT_SSL
    );

    // Check connection
    if (mysqli_connect_errno()) {
        die('Connection failed: ' . mysqli_connect_error());
    }
} else {
    // Standard connection for local development
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
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
