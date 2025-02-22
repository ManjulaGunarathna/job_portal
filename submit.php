<!DOCTYPE html>
<html>
<head>
    <title>Job Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label, input, select {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background: blue;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Job Application Form</h2>
    <form action="submit.php" method="POST" enctype="multipart/form-data">
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        
        <label>Last Name:</label>
        <input type="text" name="last_name" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Contact Number:</label>
        <input type="tel" name="contact_number" required>
        
        <label>District:</label>
        <select name="district" required>
            <option value="Colombo">Colombo</option>
            <option value="Gampaha">Gampaha</option>
            <option value="Kandy">Kandy</option>
            <option value="Galle">Galle</option>
            <option value="Matara">Matara</option>
            <option value="Kurunagala">Kurunagala</option>
            <option value="Puttalama">Puttalama</option>
            <option value="Jaffna">Jaffna</option>
            <option value="Trincomalee">Trincomalee</option>
            <option value="Baticlo">Baticlo</option>
        </select>
        
        <label>Position Applied For:</label>
        <select name="position_applied" required>
            <option value="Graduate Civil Engineer">Graduate Civil Engineer</option>
            <option value="Senior Civil Engineer">Senior Civil Engineer</option>
            <option value="MEP Engineer">MEP Engineer</option>
            <option value="Senior MEP Engineer">Senior MEP Engineer</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Structural Engineer">Structural Engineer</option>
            <option value="Site Supervisor">Site Supervisor</option>
        </select>
        
        <label>Upload CV:</label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
require 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $district = htmlspecialchars(trim($_POST['district']));
    $position_applied = htmlspecialchars(trim($_POST['position_applied']));
    
    // File upload security
    $allowed_types = ['application/pdf'];
    if (!in_array($_FILES['cv']['type'], $allowed_types) || $_FILES['cv']['size'] > 2097152) {
        die("Invalid file type or file too large.");
    }
    
    $cv_path = 'uploads/' . basename($_FILES['cv']['name']);
    move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);
    
    $sql = "INSERT INTO applicants (first_name, last_name, email, contact_number, district, position_applied, cv_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $contact_number, $district, $position_applied, $cv_path);
    if ($stmt->execute()) {
        // Send email notification
        $subject = "Job Application Submitted";
        $message = "Dear $first_name,\n\nThank you for applying for the position of $position_applied. Your application has been received successfully.\n\nBest Regards,\nCompany HR";
        $headers = "From: hr@company.com";
        mail($email, $subject, $message, $headers);
        echo "Application submitted successfully!";
    } else {
        echo "Error submitting application.";
    }
}
?>
