<?php
/**
 * MENS HUB PRIME - Front Controller
 */

// Enable Gzip Compression for the main document
if(!ob_start("ob_gzhandler")) ob_start();

// Load the Bootstrap (Initializes DB, Session, Security, and Autoloading)
require_once __DIR__ . '/src/bootstrap.php';

// Initialize and execute the Router
$router = new Router();
$router->dispatch();
?>
