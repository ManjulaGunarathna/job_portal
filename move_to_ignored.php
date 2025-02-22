<?php
require 'db_connect.php';
$id = $_GET['id'];
$sql = "INSERT INTO ignored_applicants SELECT * FROM applicants WHERE id = $id";
$conn->query($sql);
$conn->query("DELETE FROM applicants WHERE id = $id");
header("Location: admin_dashboard.php");
exit();
?>