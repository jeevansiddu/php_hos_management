<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get email and password from form
  $email = $_POST["email"];
  $password = $_POST["password"];
  $radioVal = $_POST["radiotype"];
  // Connect to database
  $conn = mysqli_connect("localhost", "root", "", "vithealthcare");

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  if ($radioVal == "stu") {
    // Prepare SQL statement
    $sql = "SELECT * FROM student_login WHERE email = '$email'";

    // Execute SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if email exists in database
    if (mysqli_num_rows($result) == 1) {
      // Get row from result set
      $row = mysqli_fetch_assoc($result);
      // Check if password matches
      if ($password == $row["password"]) {
        // Successful login, set session variable
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $row["email"];

        $sql = "SELECT * FROM user WHERE email = '$email'";

        // Execute SQL statement
        $result1 = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result1) == 0) {
          header("location: userdetail.php");
          exit;
        }
        $row1 = mysqli_fetch_assoc($result1);
        $_SESSION["regno"] = $row1["regno"];

        // Redirect to welcome page
        header("location: studentview.php");
        exit;
      } else {
        // Invalid password, show error message
        echo '<script>alert("Invalid email or password")</script>';
      }
    } else {
      // Email not found, show error message
      echo '<script>alert("Invalid email or password")</script>';
    }
  } else if ($radioVal == "doc") {
    // Prepare SQL statement
    $sql = "SELECT * FROM doctor_login WHERE email = '$email'";

    // Execute SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if email exists in database
    if (mysqli_num_rows($result) == 1) {
      // Get row from result set
      $row2 = mysqli_fetch_assoc($result);
      // Check if password matches
      if ($password == $row2["password"]) {
        // Successful login, set session variable
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $row2["email"];

        $sql = "SELECT * FROM doctor WHERE email = '$email'";

        // Execute SQL statement
        $result1 = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result1);
        $_SESSION["drid"] = $row1["drid"];

        // Redirect to welcome page
        header("location: doctorview.php");
        exit;
      } else {
        // Invalid password, show error message
        echo '<script>alert("Invalid email or password")</script>';
      }
    } else {
      // Invalid password, show error message
      $login_err = "Invalid email or password";
    }
  } else {
    // Email not found, show error message
    $login_err = "Invalid email or password";
  }


  // Close database connection
  mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="style.css" />
  <title>HOSPITAL MANAGEMENT</title>
</head>

<body>
  <div class="whole-cont">
    <div class="cont1">
      <form class="form" method="post">
        <div class="logo"><i class="fa fa-heart"></i> Logo</div>
        <div class="creta">Log in</div>
        <div class="radio-cont">
          <div class="div1">
            <input type="radio" id="stu" name="radiotype" value="stu" required />
            <label for="stu">STUDENT</label>
          </div>
          <div class="div1">
            <input type="radio" id="doc" name="radiotype" value="doc" />
            <label for="doc">DOCTOR</label>
          </div>
        </div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required />
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />
        <button type="submit">Log In</button>
        <div class="close">
          Dont Have an Account?
          <span><a href="./signup.php">Sign up</a></span>
        </div>
      </form>
      <?php if (isset($login_err)) {
        echo "<p style='color:red'>$login_err</p>";
      } ?>
    </div>
    <div class="cont2">
      <div class="img-cont">
        <img src="./img3.jpg" />
      </div>
    </div>
  </div>
</body>

</html>