<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require 'db_connect.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_position = isset($_GET['position']) ? $_GET['position'] : '';
$filter_district = isset($_GET['district']) ? $_GET['district'] : '';

$query = "SELECT * FROM applicants WHERE 1=1";
if ($search) {
    $query .= " AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($filter_position) {
    $query .= " AND position_applied = '$filter_position'";
}
if ($filter_district) {
    $query .= " AND district = '$filter_district'";
}
$query .= " ORDER BY submitted_at ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Job Applications</h2>
    <a href="logout.php">Logout</a>
    <form method="GET">
        <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo htmlspecialchars($search); ?>">
        <select name="position">
            <option value="">All Positions</option>
            <option value="Developer" <?php if ($filter_position == 'Developer') echo 'selected'; ?>>Developer</option>
            <option value="Designer" <?php if ($filter_position == 'Designer') echo 'selected'; ?>>Designer</option>
        </select>
        <select name="district">
            <option value="">All Districts</option>
            <option value="Colombo" <?php if ($filter_district == 'Colombo') echo 'selected'; ?>>Colombo</option>
            <option value="Kandy" <?php if ($filter_district == 'Kandy') echo 'selected'; ?>>Kandy</option>
        </select>
        <input type="submit" value="Filter">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>District</th>
            <th>Position</th>
            <th>CV</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact_number']; ?></td>
            <td><?php echo $row['district']; ?></td>
            <td><?php echo $row['position_applied']; ?></td>
            <td><a href="uploads/<?php echo $row['cv_path']; ?>" target="_blank">Download</a></td>
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
