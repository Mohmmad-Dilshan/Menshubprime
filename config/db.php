<?php

/**
 * BACKWARD COMPATIBILITY WRAPPER
 * This file now uses the professional src/Core/Database singleton.
 * It ensures that legacy code using $conn still works perfectly.
 */

require_once __DIR__ . '/../src/bootstrap.php';

// The $conn variable is already initialized in src/bootstrap.php
// But we'll ensure it's available here just in case of direct includes.
if (!isset($conn)) {
    $db = Database::getInstance();
    $conn = $db->getMysqli();
}

// Global settings and constants are also handled in bootstrap.php