<?php
$semver = "0.0.1-devel";

// Site Configuration

$config['version'] = "neoticket v".$semver; // This goes in the footer, censor if you wish
$config['site_name'] = ":: neoticket development"; // This will be appended to page titles

// Database Configuration

$dbconfig['host'] = 'localhost';
$dbconfig['name'] = 'neoticket';
$dbconfig['user'] = 'neoticket';
$dbconfig['pass'] = 'neoticket';

// Create connection
$db = new mysqli($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']);
unset($dbconfig);
// Check connection
if ($db->connect_error) {
    die("DB failure: " . $db->connect_error);
}

?>
