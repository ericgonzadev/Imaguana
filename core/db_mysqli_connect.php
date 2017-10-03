<?php
$conn = new mysqli("localhost", "id3121600_twinpair", "thebest1", "id3121600_imag");
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>