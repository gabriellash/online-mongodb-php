<?php 
include 'navbar.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Courses</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function addSection() {
      let sectionContainer = document.getElementById("sectionContainer");
      let section = document.createElement("div");
      section.innerHTML = `
        <label class="form-label inline-block mb-2 text-gray-700" for="sections">Section:</label>
        <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="sections" name="sections[]"><br><br>
        <button class="w-full my-1 add-lecture-btn bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button" onclick="addLecture(this)">Add Lecture</button>
        <div class="lectureContainer"></div>
      `;
      sectionContainer.appendChild(section);
    }

    function addLecture(btn) {
      let lectureContainer = btn.nextElementSibling;
      let lecture = document.createElement("div");
      lecture.innerHTML = `
        <label for="lecture">Lecture:</label>
        <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="lecture" name="lecture[]" class="form-label inline-block mb-2 text-gray-700"><br><br>
        <label class="form-label inline-block mb-2 text-gray-700"for="lectureUrl">Lecture URL:</label>
        <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="lectureUrl" name="lectureUrl[]"><br><br>
        <label class="form-label inline-block mb-2 text-gray-700" for="lectureDescription">Lecture Description:</label>
        <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="lectureDescription" name="lectureDescription[]"><br><br>
      `;
      lectureContainer.appendChild(lecture);
    }
  </script>
</head>
<body>
<div class=" m-20 w-50 h-full">
  <form action="teacherhome.php" method="post">
    <h2 class="text-4xl font-extrabold dark:text-black">Create a course</h2> </br>
    <label for="courseName" class="form-label inline-block mb-2 text-gray-700">Course Name:</label>
    <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="courseName" name="courseName"><br>
    <label for="courseLanguage" class="form-label inline-block mb-2 text-gray-700">Course Language:</label>
    <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="courseLanguage" name="courseLanguage"><br>
    <label for="coursePrice" class="form-label inline-block mb-2 text-gray-700">Course Price:</label>
    <input class="form-control  block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="coursePrice" name="coursePrice"><br>
    <div id="sectionContainer">
      <button class="w-full my-1 add-lecture-btn bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button" onclick="addSection()">Add Section</button>
    </div>
    <input class=" w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="submit" value="Submit">
  </form>
</div>
</body>
</html>

<?php

// Connect to MongoDB
require 'vendor/autoload.php';
$conn = new MongoDB\Client("mongodb://localhost:27017");
error_reporting(0);
// Select a database
$db = $conn->onlinedb;

// Select a collection
$courses = $db->courses;

// Get the data from the form
$courseName = $_POST["courseName"];
$courseLanguage = $_POST["courseLanguage"];
$coursePrice = $_POST["coursePrice"];
$sections = $_POST["sections"];
$lectures = $_POST["lecture"];
$lectureUrls = $_POST["lectureUrl"];
$lectureDescriptions = $_POST["lectureDescription"];

// Prepare the sections and lectures data
$sectionsData = [];
for ($i = 0; $i < count($sections); $i++) {
  $lecturesData = [];
  for ($j = 0; $j < count($lectures); $j++) {
    if ($j % count($sections) == $i) {
    $lecturesData[] = [
    "lecture" => $lectures[$j],
    "lectureUrl" => $lectureUrls[$j],
    "lectureDescription" => $lectureDescriptions[$j]
    ];
    }
    }
    $sectionsData[] = [
    "section" => $sections[$i],
    "lectures" => $lecturesData
    ];
    }
    
    // Create the document
    $document = [
    "courseName" => $courseName,
    "courseLanguage" => $courseLanguage,
    "coursePrice" => $coursePrice,
    "sections" => $sectionsData
    ];
    
    // Insert the document into the collection
    $courses->insertOne($document);
// Redirect back to the form
echo "course has been added successfully";

?>