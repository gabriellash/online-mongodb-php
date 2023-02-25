<?php
session_start();
require 'vendor/autoload.php';

   // connect to mongo
   $DB_CONNECTION_STRING="mongodb://localhost:27017";
   $con = new MongoDB\Client($DB_CONNECTION_STRING);
  // echo "Connection to database successfully";

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = ($_POST['username']);
    $_SESSION['username'] = $_POST['username'];
    $password = ($_POST['password']);
    //$pass_hash = md5($password);
    if(empty($username)){
        die("Empty or invalid email address");
    }
    if(empty($password)){
        die("Enter your password");
    }
    // Select Database
    if($con){
        $db = $con->onlinedb;
        // Select Collection
        $collection = $db->admin;   // you may use 'admin' instead of 'Admin'
        $result = $collection->findOne(array('username' => $username,'password' => $password));


        if(!empty($result)){
            //echo "You are successfully loggedIn";
            $role = $result['role'];
            if($role == "teacher"){
              header("Location: teacherhome.php");
            }else if($role == "student"){
              header("Location: studenthome.php");
            }
        }else{
            echo "Wrong combination of username and password";
        }
    }else{
        die("Mongo DB not connected!");
    }
}


?>

<html>
    <head>
    <title> Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        
        <section class="h-screen">
  <div class="px-6 h-full text-gray-800">
    <div
      class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
    
      <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
        <form action="login.php" method="POST">
          <div
            class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5"
          >
            <p class="text-center font-semibold mx-4 mb-0">Login</p>
          </div>

          <!-- Email input -->
          <div class="mb-6">
            <input
            type="text" id="username" name="username"
              class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              placeholder="username"
            />
          </div>

          <!-- Password input -->
          <div class="mb-6">
            <input
              type="password" id="password" name="password"
              class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              placeholder="Password"
            />
          </div>


          <div class="text-center lg:text-left">
            <button name="submit" id="submit" type="submit" value="Login"
              class="inline-block w-full px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
            >
              Login
            </button>
            <p class="text-sm font-semibold mt-2 pt-1 mb-0">
              Don't have an account?
              <a
                href="registration.php"
                class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out"
                >Register</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


    </body>
</html>