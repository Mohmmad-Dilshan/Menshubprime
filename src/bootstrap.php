<?php
/**
 * MENS HUB PRIME - Professional Bootstrap
 * Handles autoloading, configuration, and global initializations.
 */

define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('DEV_MODE', false); // Set to false for production

// Autoloading
spl_autoload_register(function($class) {
    // Basic PSR-4 style autoloading
    $class = str_replace('\\', '/', $class);
    $file = SRC_PATH . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Fallback for Core classes if namespace is not used
        $coreFile = SRC_PATH . '/Core/' . $class . '.php';
        if (file_exists($coreFile)) {
            require_once $coreFile;
        }
    }
});

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting
if (defined('DEV_MODE') && DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Initialize Database connection for backward compatibility ($conn)
require_once __DIR__ . '/Core/Database.php';
$db = Database::getInstance();
$conn = $db->getMysqli();

if(!$conn){
    die("Database connection failed: Error during bootstrap.");
}

// Global settings from DB
$settings_q = mysqli_query($conn, "SELECT * FROM settings LIMIT 1");
$sys = mysqli_fetch_assoc($settings_q);

// Load Secret Config
$creds = require_once __DIR__ . '/../config/db_credentials.php';

// Define Global constants
if (!defined('RAZORPAY_KEY_ID')) {
    define('RAZORPAY_KEY_ID', $sys['razorpay_key_id'] ?? $creds['razorpay_id']);
}
if (!defined('RAZORPAY_KEY_SECRET')) {
    define('RAZORPAY_KEY_SECRET', $sys['razorpay_key_secret'] ?? $creds['razorpay_secret']);
}
if (!defined('ADMIN_EMAIL')) {
    define('ADMIN_EMAIL', $sys['admin_email'] ?? 'your-email@example.com');
}

// Additional Helpers can be required here
// require_once __DIR__ . '/Helpers/Security.php';
