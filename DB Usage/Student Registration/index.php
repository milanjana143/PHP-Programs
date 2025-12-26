<?php
// index.php

// DB server credentials (default XAMPP)
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";      // default XAMPP: empty password
$dbname = "college_db";

// Create connection to MySQL server (no DB selected yet)
$conn = new mysqli($servername, $dbusername, $dbpassword);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (!$conn->query($sqlCreateDB)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create students table if not exists
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    roll INT(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if (!$conn->query($sqlCreateTable)) {
    die("Error creating table: " . $conn->error);
}

// Handle form submission (use POST)
$successMsg = "";
$errorMsg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get and trim inputs
    $name = trim($_POST['name'] ?? '');
    $roll = trim($_POST['roll'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Basic validation (more can be added)
    if ($name === '' || $roll === '' || $department === '' || $email === '') {
        $errorMsg = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Please provide a valid email address.";
    } else {
        // Prepared statement to insert record safely
        $stmt = $conn->prepare("INSERT INTO students (name, roll, department, email) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            $errorMsg = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("ssss", $name, $roll, $department, $email);
            if ($stmt->execute()) {
                $successMsg = "New student record inserted successfully!";
            } else {
                $errorMsg = "Insert failed: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Insert Student Record</title>
    <meta charset="utf-8">
</head>
<body style="font-family:Arial; margin:40px;">
<h2>Student Registration Form</h2>

<?php if ($successMsg): ?>
    <p style="color:green;"><?php echo htmlspecialchars($successMsg); ?></p>
<?php endif; ?>

<?php if ($errorMsg): ?>
    <p style="color:red;"><?php echo htmlspecialchars($errorMsg); ?></p>
<?php endif; ?>

<form action="" method="POST">
    <label>Student Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Roll No:</label><br>
    <input type="text" name="roll" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<hr>
<h3>Existing Students (latest 10)</h3>
<?php
// Show a few rows so you can confirm insertion works
$result = $conn->query("SELECT id, name, roll, department, email FROM students ORDER BY id ASC LIMIT 10");
if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Roll</th><th>Department</th><th>Email</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>"
           . "<td>" . htmlspecialchars($row['id']) . "</td>"
           . "<td>" . htmlspecialchars($row['name']) . "</td>"
           . "<td>" . htmlspecialchars($row['roll']) . "</td>"
           . "<td>" . htmlspecialchars($row['department']) . "</td>"
           . "<td>" . htmlspecialchars($row['email']) . "</td>"
           . "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records yet.</p>";
}
$conn->close();
?>

</body>
</html>
