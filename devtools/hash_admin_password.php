<?php

/**
 * MENS HUB PRIME - Ultimate Password Migrator
 * This tool converts all plain-text admin passwords into secure BCRYPT hashes.
 * Security: Locked to localhost only.
 */

require_once __DIR__ . '/../src/bootstrap.php';

// Security: Only allow running from localhost to prevent remote attacks
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die("Error: This tool can only be run from the local server for security reasons.");
}

echo "<h2>MENS HUB PRIME - Password Security Upgrade</h2>";

// Fetch all admin accounts
$query = mysqli_query($conn, "SELECT id, username, password FROM admin");

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $user = $row['username'];
        $pass = $row['password'];

        // Check if already hashed (BCRYPT hashes start with $2y$)
        if (strpos($pass, '$2y$') === 0) {
            echo "Skipping <strong>$user</strong>: Password already hashed.<br>";
            continue;
        }

        // Create secure hash
        $new_hash = password_hash($pass, PASSWORD_BCRYPT);

        // Update database
        $update = mysqli_query($conn, "UPDATE admin SET password='$new_hash' WHERE id=$id");

        if ($update) {
            echo "Successfully Hashed password for <strong>$user</strong> ✅<br>";
        } else {
            echo "Failed to update <strong>$user</strong>: " . mysqli_error($conn) . " ❌<br>";
        }
    }
} else {
    echo "No admin accounts found in database.";
}

echo "<br><p style='color:green;'><b>SECURITY UPGRADE COMPLETE!</b> You can now safely use the modern login system.</p>";
echo "<p style='color:red;'>IMPORTANT: Please DELETE this file (devtools/hash_admin_password.php) after use.</p>";
