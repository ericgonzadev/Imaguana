<?php
include_once 'core/db_mysqli_connect.php';
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>