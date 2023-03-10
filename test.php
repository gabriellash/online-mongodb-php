<?php
require 'vendor/autoload.php';

// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

$db = $conn->onlinedb;

// create a new collection named "mycollection"
$collection = $db->createCollection("admin");

?>