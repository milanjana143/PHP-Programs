<?php

// DB credentials (XAMPP defaults). Not mandatory to mention these 4 lines.
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "mysql";

// connect to MySQL
$conn = new mysqli("localhost", "root", "", "mysql");

// check connection
if (!$conn) {
  die("Connection failed: ");
}

// create db if not exist
$conn->query("CREATE DATABASE IF NOT EXISTS student");

// select the created db to create a table in it
$conn->select_db("student");

// create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS college (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  email VARCHAR(50))");

// insert data
if (isset($_POST['save'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $conn->query("INSERT INTO college (name, email) VALUES ('$name', '$email')");
}

// fetch data
$result = $conn->query("SELECT * FROM college");
?>

<!DOCTYPE html>
<html>
<body>

<form method="post">
  Name: <input name="name">
  Email: <input name="email">
  <button name="save">Save</button>
</form>

<h4>Saved Data:</h4>

<?php 
while($row = $result->fetch_assoc()) {
 echo $row['id'].' '.$row['name'].' '.$row['email'].'<br>';
}
?>


</body>
</html>