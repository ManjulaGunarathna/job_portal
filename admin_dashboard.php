<?php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
$result = $conn->query("SELECT * FROM applicants ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>District</th>
            <th>Position Applied</th>
            <th>CV</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact_number']; ?></td>
            <td><?php echo $row['district']; ?></td>
            <td><?php echo $row['position_applied']; ?></td>
            <td><a href="<?php echo $row['cv_path']; ?>" target="_blank">Download</a></td>
            <td>
                <a href="move_to_contacted.php?id=<?php echo $row['id']; ?>">Contacted</a> |
                <a href="move_to_ignored.php?id=<?php echo $row['id']; ?>">Ignore</a> |
                <a href="delete_application.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>