<?php
require 'vendor/autoload.php';
include 'navbar.php';
// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $conn->onlinedb;

// Select a collection
$courses = $db->courses;

if (isset($_GET['id'])) {
  // Get the course document with the specified ID
  $document = $courses->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]);
} else {
  header('Location: index.php');
  exit();
}

if (isset($_POST['update'])) {
    $updatedSections = [];
    foreach ($_POST['sections'] as $section) {
      $updatedLectures = [];
      foreach ($section['lectures'] as $lecture) {
        $updatedLectures[] = [
          'lecture' => $lecture['lecture'],
          'lectureUrl' => $lecture['lectureUrl'],
          'lectureDescription' => $lecture['lectureDescription']
        ];
      }
      $updatedSections[] = [
        'section' => $section['section'],
        'lectures' => $updatedLectures
      ];
    }
    // Update the course document
    $updateResult = $courses->updateOne(
      ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])],
      [
        '$set' => [
          'courseName' => $_POST['courseName'],
          'courseLanguage' => $_POST['courseLanguage'],
          'coursePrice' => $_POST['coursePrice'],
          'sections' => $updatedSections
        ],
      ]
    );
  
    if ($updateResult->getModifiedCount() > 0) {
      header('Location: courses.php');
      exit();
    } else {
      echo 'Error updating course';
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<form action="" method="post">
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-16">
    <table class="w-full text-m text-left">
      <tr>
        <td><b>Course Name</b></td>
        <td><input type="text" name="courseName" value="<?php echo $document->courseName; ?>"></td>
      </tr>
      <tr>
        <td><b>Course Language</b></td>
        <td><input type="text" name="courseLanguage" value="<?php echo $document->courseLanguage; ?>"></td>
      </tr>
      <tr>
        <td><b>Course Price</b></td>
        <td><input type="text" name="coursePrice" value="<?php echo $document->coursePrice; ?>"></td>
      </tr>
      <?php
      foreach ($document->sections as $sectionIndex => $section) {
        echo '<tr><td><b>Section</b></td>';
        echo '<td><input type="text" name="sections[' . $sectionIndex . '][section]" value="' . $section->section . '"></td></tr>';
        foreach ($section->lectures as $lectureIndex => $lecture) {
          echo '<tr><td><b>Lecture ' . ($lectureIndex + 1) . '</b></td>';
          echo '<td><input type="text" name="sections[' . $sectionIndex . '][lectures][' . $lectureIndex . '][lecture]" value="' . $lecture->lecture . '"></td></tr>';
          echo '<tr><td><b>Lecture URL ' . ($lectureIndex + 1) . '</b></td>';
          echo '<td><input type="text" name="sections[' . $sectionIndex . '][lectures][' . $lectureIndex . '][lectureUrl]" value="' . $lecture->lectureUrl . '"></td></tr>';
          echo '<tr><td><b>Lecture Description ' . ($lectureIndex + 1) . '</b></td>';
          echo '<td><input type="text" name="sections[' . $sectionIndex . '][lectures][' . $lectureIndex . '][lectureDescription]" value="' . $lecture->lectureDescription . '"></td></tr>';
        }
      }
      ?>
      <tr>
        <td><br></td>
        <td><input type="submit" name="update" value="Update Course"></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
