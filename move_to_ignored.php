<?php
require 'db_connect.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("INSERT INTO ignored_applicants SELECT * FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_dashboard.php");
}
?>