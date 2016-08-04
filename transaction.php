<?php
require 'core/init.php';
    
// Create connection
include_once 'core/db_mysqli_connect.php';

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
    $result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id . " AND image_id = " . $image->data()->id . " AND license = 'unlimited'");
    echo "result->num_rows = " . $result->num_rows;
    if ($result->num_rows > 0){
        header("location: ./purchases.php#" . $image->data()->id);
    }
}
?>
        

