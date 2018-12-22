<?php
// Debug
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Vendor
$vendorPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die('composer install for root directory required');
}
require __DIR__ . '/../vendor/autoload.php';