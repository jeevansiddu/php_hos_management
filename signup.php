<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get email, password, and confirmation password from form
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  // Check if password and confirmation password match
  if ($password !== $confirm_password) {
    $signup_err = "Password and confirmation password do not match";
  } else {
        // Connect to database
        $conn = mysqli_connect("localhost", "root", "", "vithealthcare");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if email already exists in database
        $sql = "SELECT * FROM student_login WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Email already exists, show error message
            $signup_err = "Email already taken, Kindly login";
        } else {
            // Email doesn't exist, insert new user into database
            $sql = "INSERT INTO student_login (email, password) VALUES ('$email', '$password')";
            if (mysqli_query($conn, $sql)) {
            // User created successfully, redirect to login page
            header("location: login.php");
            } else {
            // Error creating user, show error message
            $signup_err = "Error creating user";
            }
        }
        
        // Close database connection
        mysqli_close($conn);
  }

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="style2.css" />
    <title>HOSPITAL MANAGEMENT</title>
  </head>
  <body>
    <div class="whole-cont">
      <div class="cont1">
        <form class="form" method="post">
          <div class="logo"><i class="fa fa-heart"></i> Logo</div>
          <div class="creta">Create Account</div>
          <label for="email">Email</label>
          <input type="text" name="email" id="email" required/>
          <label for="pass">Password</label>
          <input type="password" name="password" id="pass" required/>
          <label for="pass">Confirm Password</label>
          <input type="password" name="confirm_password" id="cpass" required/>
          <button type="submit">Sign Up</button>
          <div class="close">
            Already Have an Account?
            <span><a href="./login.php">Log In</a></span>
          </div>
        </form>
        <?php if (isset($signup_err)) { echo "<p style='color:red'>$signup_err</p>"; } ?>
      </div>
      <div class="cont2">
        <div class="img-cont">
          <img src="./img3.jpg" />
        </div>
      </div>
    </div>
  </body>
</html>
