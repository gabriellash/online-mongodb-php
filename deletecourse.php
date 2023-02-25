<?php
require 'vendor/autoload.php';
include 'navbar.php';
// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $conn->onlinedb;

// Select a collection
$courses = $db->courses;

// Get the course ID from the URL
$id = $_GET['id'];

// Check if a course ID has been provided
if (isset($id)) {
  // Delete the course with the given ID
  $courses->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

  // Redirect to the courses list
  header("Location: courses.php");
}

// Get all the courses in the collection
$documents = $courses->find();

?>