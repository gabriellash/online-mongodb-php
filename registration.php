
<html>
    <head>
        <title>Registration</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <section class="h-screen">
            <div class="px-6 h-full text-gray-800">
                <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
                    <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                        <form action="registration.php" method="POST">
                            <div class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5">
                                <p class="text-center font-semibold mx-4 mb-0">Registration</p>
                            </div>

                            <!-- Name input -->
                            <div class="mb-6">
                                <input type="text" id="name" name="name" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Full Name">
                            </div>

                            <!-- Email input -->
                            <div class="mb-6">
                                <input type="text" id="email" name="email" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Email">
                            </div>

                            <!-- Username input -->
                            <div class="mb-6">
                                <input type="text" id="username" name="username" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Username">
                            </div>

                            <!-- Password input -->
                            <div class="mb-6">
                                <input type="password" id="password" name="password" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Password">
                            </div>

                            <!-- Role selection -->
                            <div class="mb-6">
                                <select id="role" name="role" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                  </select>
                            </div>

                            <div class="text-center lg:text-left">
                                <button type="submit" value="Submit" class="inline-block w-full px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow--lg">Register</button>
                                <p class="text-sm font-semibold mt-2 pt-1 mb-0">
              Already have an account?
              <a
                href="login.php"
                class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out"
                >Login</a>
            </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>

</html>



<?php
error_reporting(0);
require 'vendor/autoload.php';
// Connect to the MongoDB database
$client = new MongoDB\Client("mongodb://localhost:27017");

// Select a database
$db = $client->onlinedb;

// Select a collection
$collection = $db->admin;

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];


// Create a document
$document = [
  'name' => $name,
  'email' => $email,
  'username' => $username,
  'password' => $password,
  'role' => $_POST['role']
];

$emailExists = $collection->findOne(['email' => $email]);

// Check if the username already exists
$usernameExists = $collection->findOne(['username' => $username]);

// If either the email or username already exists, display an error message
    if ($emailExists || $usernameExists) {
    echo "Error: Email or username already exists.";
    } else {
    // Insert the document into the collection
    $collection->insertOne($document);

    // Redirect the user to the success page
    header('Location: login.php');
    }
  
?>


