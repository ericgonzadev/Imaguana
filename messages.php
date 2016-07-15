<?php
require 'core/init.php';

// Create connection
$conn = new mysqli("sfsuswe.com", "s16g09", "9team2016", "student_s16g09");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('./login.php');
}

if ($user->data()->group != 3) {
    Redirect::to(404);
}
$result = $conn->query("SELECT * FROM messages");
?>

<!DOCTYPE html>
<head>
    <title>Imaguana | Messages</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>

</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>
    
    <style type="text/css">
        td,th{
            font-size: 25px;
            color: black;
        }
    </style>

    <!-- Page Content -->
    <h1 align="center" style="color:black;">All Messages</h1><br>

    <table align= "center" border = "5" id="suggestions"> 
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
    <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["email"] ?></td>
                <td><?php echo $row["message"] ?></td>
            </tr>
    <?php   }
        }
        else{
            echo "<p align='center'> No Messages</p>";
        }
?>

    </table><br><br>
    
     <!-- Foot Bar -->
    <div>
        <?php include 'view/foot-bar.php'; ?>
    </div>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>
    
</body>
</html>