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

// Check if the course has already been purchased by the user
$purchased = false;
$mycourses = $db->mycourses;
$purchasedCourses = $mycourses->find(['username' => $_SESSION['username']]);
foreach ($purchasedCourses as $purchasedCourse) {
    if ($purchasedCourse['course']['_id'] == $course['_id']) {
        $purchased = true;
        break;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy Course</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <br><br>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-12">
    <table class="w-full text-m text-left ">
      <tr>
        <td>ID</td>
        <td><?php echo $course->_id;?></td>
</tr>
<tr>
<td><b>Course Name</td></b>
<td><?php echo $course->courseName; ?></td>
</tr>
<tr>
<td>Course Language</td>
<td><?php echo $course->courseLanguage; ?></td>
</tr>
<tr>
<td>Course Price</td>
<td><?php echo $course->coursePrice; ?></td>
</tr>
</table>
<br><br>
<div class="flex items-center justify-center">

</div>
<br><br>
<div class="flex items-center justify-center">
<?php if (!$purchased): ?>
<h2><b>Do you want to have access to this course?</b></h2> 
<a href="payment.php?id=<?php echo $course->_id; ?>">
<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold m-2 py-2 px-4 rounded">
Yes, get course
</button>
</a>
<?php endif; ?>
<a href="studenthome.php">
<button class="bg-red-500 hover:bg-red-700 text-white font-bold m-2 py-2 px-4 rounded">
Cancel
</button>
</a>
</div>

  </div>
</body>
</html> 