<?php

//content type
header('Content-type: multipart/form-data');
//open/save dialog box
header('Content-Disposition: attachment; filename="' . $_POST['name'] . '"');
//read from server and write to buffer
readfile("http://imag-uana.rhcloud.com/uploads/uploads/" . $_POST['name']);

?>

