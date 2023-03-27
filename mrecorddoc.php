<?php

session_start(); // Start session
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}
if (!isset($_SESSION["email"]) || !isset($_SESSION["drid"])) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}

$mrid = $_GET["mrid"];
$drid = $_SESSION["drid"];
$regno = $_GET["regno"];
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vithealthcare";
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM user WHERE regno = $regno";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row["firstname"];
    $email = $row["email"];
    $age = $row["dob"];
    $batch = $row["batch"];
    $mob_no = $row["mobile"];
    $room_no = $row["roomno"];
} else {
    $row = "No data found";
}


$sql = "SELECT * FROM medical_record WHERE mrid =" . $mrid;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row1 = mysqli_fetch_assoc($result);
    $app_for = $row1["disease_title"];
    $symptoms = $row1["symptoms"];
    $duration = $row1["howlong"];
    $severity = $row1["severity"];
    $desc = $row1["disease_description"];
} else {
    $row1 = "No data found";
}
$sql = "SELECT firstname FROM doctor WHERE drid =" . $drid;
$result2 = mysqli_query($conn, $sql);
if (mysqli_num_rows($result2) == 1) {
    $row2 = mysqli_fetch_assoc($result2);
    $fname = $row2["firstname"];

} else {
    $fname = "No name";
}
//Doubt on post method how to receive
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get data from form
//     $desc = $_POST["pres"];

//     // Insert data into the database using PDO
//     try {
//         // Define database credentials
//         $host = "localhost";
//         $dbname = "vithealthcare";
//         $user = "root";
//         $password = "";
//         // Connect to the database using PDO
//         $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Prepare SQL query for insertion
//         $sql = "INSERT INTO medical_solution (comments, drid, mrid, msid, sex, roomno, batch, mobile, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
//         $stmt = $pdo->prepare($sql);
//     }

// }
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link rel="stylesheet" href="./mrecordstu2.css">
    <link rel="stylesheet" href="./mrecordstu.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        .pres-cont {
            display: flex;
            flex-direction: row;
            text-align: right;
            justify-content: flex-end;
            padding-right: 1.5rem;
        }


        .pres-by {
            padding-right: 3rem;
        }

        .tot-pres-cont {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            text-align: right;
            padding-bottom: 1rem;
            /* padding-right: 2rem; */

        }

        .doc-pres textarea {
            all: unset;
            border: 1px solid black;
            margin-right: 3%;

            /* content-ed */
        }

        .value {
            width: 90%;
        }

        /* .doc-pres .name {
            text-align: left;
        } */
    </style>
</head>

<body>
    <div class="top-header">
        <div class="logo-content">
            <img src="./logo-removebg-preview.png" style="background-color: white" width="60px" height="50px"
                style="margin-top: 0.6vh" alt="logo" />
            <div>
                <h2 style="color: white; text-align: center">VIT</h2>
                <hr style="color: white" />
                <h4 style="color: white">Hospital Management System</h4>
            </div>
        </div>
        <!-- <button class="logout">Logout</button> -->
        <!-- HTML !-->
        <button class="button-29" role="button">Logout</button>
    </div>

    <div class="side-header">
        <div class="side-cont">
            <a href="studentview.php" class="home">
                <i class="fa fa-home" aria-hidden="true"></i> Home
            </a>
            <a href="studentprofile.php" class="profile">
                <i class="fa fa-user" aria-hidden="true"></i> Profile
            </a>
            <a href="query.php" class="query">
                <i class="fa fa-question-circle" aria-hidden="true"></i> Raise Query
            </a>
        </div>
    </div>
    <div class="main">
        <div class="pat-cont">
            <div class="dis-des">
                <div class="img-icon"><i class="fa fa-plus"></i></div>
                <div class="name">Query Decomposition</div>
                <div class="details">Details</div>
                <div class="m-cont">
                    <div class="input">Appointment For:</div>
                    <div class="value">
                        <?php echo $app_for; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Symptoms:</div>
                    <div class="value">
                        <?php echo $symptoms; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Duration:</div>
                    <div class="value">
                        <?php echo $duration; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Severity:</div>
                    <div class="value">
                        <?php echo $severity; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Brief Description:</div>
                    <textarea id="desc" class="value" name="desc"><?php echo $desc; ?></textarea>
                </div>
            </div>
            <div class="stu-des">
                <div class="img-icon"><i class="fa fa-user"></i></div>
                <div class="name">
                    <?php echo $name; ?>
                </div>
                <div class="email">
                    <?php echo $email; ?>
                </div>
                <div class="details">Details</div>
                <div class="m-cont">
                    <div class="input">Age:</div>
                    <div class="value">
                        <?php echo $age; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Batch:</div>
                    <div class="value">
                        <?php echo $batch; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Mobile No:</div>
                    <div class="value">
                        <?php echo $mob_no; ?>
                    </div>
                </div>
                <div class="m-cont">
                    <div class="input">Room No:</div>
                    <div class="value">
                        <?php echo $room_no; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="doc-pres-cont">
            <div class="doc-pres">
                <div class="img-icon"><i class="fa fa-stethoscope"></i></div>
                <div class="name">Doctor Prescription</div>
                <form class="value" method="post">
                    <textarea id="pres" class="value" name="desc"></textarea>
                    <button type="submit">Submit</button>
                </form>
                <div class="tot-pres-cont">
                    <div class="pres-by">Prescribed by: </div>
                    <div class="pres-cont">
                        <div class="doc-name">Doctor Name:</div>
                        <div class="value">
                            <?php echo $fname; ?>
                        </div>
                    </div>
                    <div class="pres-cont">
                        <div class="doc-id">Doctor Id:</div>
                        <div class="value">
                            <?php echo $drid; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>