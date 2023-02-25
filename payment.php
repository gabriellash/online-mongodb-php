<?php
session_start();
require 'vendor/autoload.php';
include 'navbarst.php';

// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $conn->onlinedb;

// Select a collection
$courses = $db->courses;

if (isset($_GET['id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['id']);
    $course = $courses->findOne(['_id' => $id]);
  } else {
    header("Location: studenthome.php");
  }
  
  // Add the purchase to the users collection
  $user = $db->admin;
  $userDoc = $user->findOne(['username' => $_SESSION['username']]);
  
  if (!isset($userDoc['mycourses']) || !is_array($userDoc['mycourses'])) {
    $userDoc['mycourses'] = [];
  }
  
  $alreadyPurchased = false;
  
  foreach ($userDoc['mycourses'] as $mycourse) {
    if ($mycourse['_id'] == $course['_id']) {
      $alreadyPurchased = true;
      break;
    }
  }
  
  if (!$alreadyPurchased) {
    $user->updateOne(
      ['username' => $_SESSION['username']],
      ['$push' => ['mycourses' => $course]]
    );
  
    // Add the purchase to the purchasedCourses collection
    $mycourses = $db->mycourses;
    $mycourses->insertOne(['username' => $_SESSION['username'], 'course' => $course]);
  }

header("Location: studenthome.php");
?>
