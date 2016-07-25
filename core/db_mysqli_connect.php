<?php
$conn = new mysqli(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), getenv('OPENSHIFT_GEAR_NAME'));
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>