<?php

//content type
header('Content-type: multipart/form-data');
//open/save dialog box
header('Content-Disposition: attachment; filename="' . $_POST['image'] . '"');
//read from server and write to buffer
readfile("uploads/" . $_POST['image']);

?>

