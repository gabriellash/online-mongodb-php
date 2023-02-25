

<?php
require 'vendor/autoload.php';
include 'navbar.php';
// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $conn->onlinedb;

// Select a collection
$courses = $db->courses;

// Get all the documents in the collection
$documents = $courses->find();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <br><br>
    <?php foreach ($documents as $document) { ?>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-12">
    <table class="w-full text-m text-left ">
      <tr>
        <td>ID</td>
        <td><?php echo $document->_id; ?></td>
      </tr>
      <tr>
        <td><b>Course Name</td></b>
        <td><?php echo $document->courseName; ?></td>
      </tr>
      <tr>
        <td>Course Language</td>
        <td><?php echo $document->courseLanguage; ?></td>
      </tr>
      <tr>
        <td>Course Price</td>
        <td><?php echo $document->coursePrice; ?></td>
      </tr>
    </table>

    <h2><b>Sections</h2></b>
    <table class="w-full text-m text-left">
      <?php foreach ($document->sections as $section) { ?>
        <tr>
          <td>Section</td>
          <td><?php echo $section->section; ?></td>
        </tr>
        <tr>
          <td>Lectures</td>
          <td>
            <!-- Display the lectures -->
            <table class="w-full text-m text-left">
              <?php foreach ($section->lectures as $lecture) { ?>
                <tr>
                  <td>Lecture</td>
                  <td><?php echo $lecture->lecture; ?></td>
                </tr>
                <tr>
                  <td>Lecture URL</td>
                  <td><?php echo $lecture->lectureUrl; ?></td>
                </tr>
                <tr>
                  <td>Lecture Description</td>
                  <td><?php echo $lecture->lectureDescription; ?></td>
                </tr>
              <?php } ?>
            </table>
          </td>
        </tr>
      <?php } ?>
    </table>

    <div class="flex items-center justify-end">
   
    <a href="deletecourse.php?id=<?php echo $document->_id; ?>">  <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 m-2 rounded">
        Delete Course
      </button></a>    <a href="updatecourse.php?id=<?php echo $document->_id; ?>">  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold m-2 py-2 px-4 rounded">
        Edit Course
      </button></a>
    </div>
  </div>
<?php } ?>

</body>
</html>
<!-- Display the data -->
