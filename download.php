<?php

//content type
header('Content-type: multipart/form-data');
//open/save dialog box
header('Content-Disposition: attachment; filename="' getenv('OPENSHIFT_DATA_DIR'). "/uploads/" . $_POST['name'] . '"');
//read from server and write to buffer
readfile(getenv('OPENSHIFT_DATA_DIR'). "/uploads/" . $_POST['name']);

?>

