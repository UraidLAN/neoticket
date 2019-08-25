<?php

// Site Configuration

$config['site_name'] = "neoticket v0.0.1";

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
