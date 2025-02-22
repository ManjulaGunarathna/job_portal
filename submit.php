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
            <option value="Kurunagala">Kandy</option>
            <option value="Puttalama">Kandy</option>
            <option value="Jaffna">Kandy</option>
        </select>
        
        <label>Position Applied For:</label>
        <select name="position_applied" required>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Project Manager">Project Manager</option>
            <option value="Civil Engineer">Civil Engineer</option>
            <option value="Structural Engineer">Structural Engineer</option>
            <option value="Site Supervisor">Site Supervisor</option>
        </select>
        
        <label>Upload CV:</label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
