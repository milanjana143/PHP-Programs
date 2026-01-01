<?php
// index.php - Employee CRUD (safe, single file)

// DB credentials (XAMPP defaults)
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "company_db";

// Connect to MySQL server
$conn = new mysqli($servername, $dbusername, $dbpassword);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
$conn->select_db($dbname);

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS employee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(100),
    salary DECIMAL(12,2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Messages
$success = "";
$error = "";

// ---------- INSERT ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $salary = trim($_POST['salary'] ?? '');

    if ($name === '' || $designation === '' || $salary === '') {
        $error = "Please fill all fields to add an employee.";
    } elseif (!is_numeric($salary)) {
        $error = "Salary must be a number.";
    } else {
        $stmt = $conn->prepare("INSERT INTO employee (name, designation, salary) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $designation, $salary);
        if ($stmt->execute()) {
            $success = "New employee added successfully!";
        } else {
            $error = "Insert failed: " . $stmt->error;
        }
        $stmt->close();
    }
}

// ---------- DELETE ----------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM employee WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success = "Record deleted successfully!";
        } else {
            $error = "Delete failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Invalid ID for deletion.";
    }
}

// ---------- UPDATE ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $salary = trim($_POST['salary'] ?? '');

    if ($id <= 0 || $name === '' || $designation === '' || $salary === '') {
        $error = "Please fill all fields to update.";
    } elseif (!is_numeric($salary)) {
        $error = "Salary must be a number.";
    } else {
        $stmt = $conn->prepare("UPDATE employee SET name = ?, designation = ?, salary = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $designation, $salary, $id);
        if ($stmt->execute()) {
            $success = "Employee updated successfully!";
        } else {
            $error = "Update failed: " . $stmt->error;
        }
        $stmt->close();
    }
}

// If editing, fetch the employee record
$editRow = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT id, name, designation, salary FROM employee WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $editRow = $res->fetch_assoc();
        $stmt->close();
    }
}

// Fetch all employees for display
$result = $conn->query("SELECT id, name, designation, salary FROM employee ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee CRUD Operations</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        label { display:inline-block; width:100px; margin-top:8px; }
        input[type=text], input[type=number] { width:220px; padding:6px; }
        table { border-collapse: collapse; margin-top: 16px; width: 100%; max-width: 800px; }
        table td, table th { border:1px solid #ccc; padding:8px; text-align:left; }
        .msg-success { color: green; }
        .msg-error { color: red; }
        .actions a { margin-right:8px; }
    </style>
</head>
<body>

<h2>Employee Management System (CRUD)</h2>

<?php if ($success): ?><p class="msg-success"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>
<?php if ($error): ?><p class="msg-error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

<!-- INSERT FORM -->
<h3>Add New Employee</h3>
<form method="POST" action="">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Designation:</label>
    <input type="text" name="designation" required>
    <br>
    <label>Salary:</label>
    <input type="number" step="0.01" name="salary" required>
    <br><br>
    <input type="submit" name="add" value="Add Employee">
</form>

<hr>

<!-- DISPLAY EMPLOYEE LIST -->
<h3>Employee List</h3>
<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr style="background:#f0f0f0;">
            <th>ID</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['designation']); ?></td>
                <td><?php echo htmlspecialchars($row['salary']); ?></td>
                <td class="actions">
                    <a href="?edit=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>

<hr>

<!-- UPDATE FORM (shown only when editing) -->
<?php if ($editRow): ?>
    <h3>Update Employee (ID: <?php echo htmlspecialchars($editRow['id']); ?>)</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($editRow['id']); ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($editRow['name']); ?>" required>
        <br>
        <label>Designation:</label>
        <input type="text" name="designation" value="<?php echo htmlspecialchars($editRow['designation']); ?>" required>
        <br>
        <label>Salary:</label>
        <input type="number" step="0.01" name="salary" value="<?php echo htmlspecialchars($editRow['salary']); ?>" required>
        <br><br>
        <input type="submit" name="update" value="Update Employee">
        &nbsp; <a href="index.php">Cancel</a>
    </form>
<?php endif; ?>

</body>
</html>
<?php
// close connection
$conn->close();
?>