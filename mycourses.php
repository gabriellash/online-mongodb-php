<?php
session_start();
require 'vendor/autoload.php';
include 'navbarst.php';

// Connect to MongoDB
$conn = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $conn->onlinedb;

// Select a collection
$mycourses = $db->mycourses;

// Find the purchased courses of the user
$purchased_courses = $mycourses->find(['username' => $_SESSION['username']]);

// Check if the user has purchased any courses
if ($purchased_courses->isDead()) {
  echo "You have not purchased any courses yet.";
} else {
  echo "<b>My Courses:</b>";
  echo "<br><br>";
  echo "<div class='relative overflow-x-auto shadow-md sm:rounded-lg m-12'>";

  foreach ($purchased_courses as $purchased_course) {
    $document = $purchased_course['course'];
    echo "<table class='w-full text-m text-left '>";
    echo "<tr>";
    echo "<td>ID</td>";
    echo "<td>" . $document->_id . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>Course Name</td></b>";
    echo "<td>" . $document->courseName . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Course Language</td>";
    echo "<td>" . $document->courseLanguage . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Course Price</td>";
    echo "<td>" . $document->coursePrice . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<h2><b>Sections</h2></b>";
    echo "<table class='w-full text-m text-left'>";
    foreach ($document->sections as $section) {
      echo "<tr>";
      echo "<td>Section</td>";
      echo "<td>" . $section->section . "</td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td>Lectures</td>";
      echo "<td>";
      echo "<table class='w-full text-m text-left'>";
      foreach ($section->lectures as $lecture) {
        echo "<tr>";
        echo "<td>Lecture</td>";
        echo "<td>" . $lecture->lecture . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Lecture URL</td>";
        echo "<td>" . $lecture->lectureUrl . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Lecture Description</td>";
        echo "<td>" . $lecture->lectureDescription . "</td>";
        echo "</tr>";
      }
}
?>
  </table>
</td> </tr>
  <?php } ?>
  </table>
</div>
<?php
}
?>