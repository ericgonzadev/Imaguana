<?php
require 'core/init.php';
    
// Create connection
$conn = new mysqli("sfsuswe.com", "s16g09", "9team2016", "student_s16g09");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//user object
$user = new User();

if($_POST['type'] == "video"){
    //video object
    $video = new Video();
    $video->find($_POST['videoid']);
    
    $license = $_POST['license'];
    
    //check if user already bought the license
    $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND video_id = " . $video->data()->id . " AND license = '" . $_POST['license'] . "'");
    if ($result->num_rows > 0) {
        header("location: ./purchases.php#video_" . $video->data()->id);
    }
    else{
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, video_id, license, price, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $user_id, $video_id, $license, $price, $type);

        // set parameters and execute
        $user_id = $user->data()->id;
        $video_id = $video->data()->id;
        $license;
        $price = $video->data()->$license;
        $type = "video";

        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("location: ./purchases.php#video_" . $video->data()->id);
    }
}
else{
    //image object
    $image = new Image();
    $image->find($_POST['imageid']);       

    $license = $_POST['license'];

    //check if user already bought the license
    $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'unlimited' ");
    if ($result->num_rows > 0) {
        header("location: ./purchases.php#" . $image->data()->id);
    }

    $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = '" . $_POST['license'] . "'");
    if ($result->num_rows > 0) {
        header("location: ./purchases.php#" . $image->data()->id);
    }
    else{
        //change license to unlimited if user buys both licenses seperately
        $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'print'");
        if(($_POST['license'] == "web" || $_POST['license'] == "unlimited") && $result->num_rows > 0){
            $license = "unlimited";
            $conn->query("DELETE FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'print'");
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, image_id, license, price, type) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisis", $user_id, $image_id, $license, $price, $type);

            // set parameters and execute
            $user_id = $user->data()->id;
            $image_id = $image->data()->id;
            $license;
            $price = $image->data()->$license;
            $type = "image";

            $stmt->execute();
            $stmt->close();
            $conn->close();

            header("location: ./purchases.php#" . $image->data()->id);
        }

        $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'web'");
        if(($_POST['license'] == "print" || $_POST['license'] == "unlimited") && $result->num_rows > 0){
            $license = "unlimited";
            $conn->query("DELETE FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'web'");
            // prepare and bind
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, image_id, license, price, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $user_id, $image_id, $license, $price, $type);

        // set parameters and execute
        $user_id = $user->data()->id;
        $image_id = $image->data()->id;
        $license;
        $price = $image->data()->$license;
        $type = "image";

        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("location: ./purchases.php#" . $image->data()->id);
        }
        else{
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, image_id, license, price, type) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisis", $user_id, $image_id, $license, $price, $type);

            // set parameters and execute
            $user_id = $user->data()->id;
            $image_id = $image->data()->id;
            $license;
            $price = $image->data()->$license;
            $type = "image";

            $stmt->execute();
            $stmt->close();
            $conn->close();

            header("location: ./purchases.php#" . $image->data()->id);
        }
    }
}
?>
        

