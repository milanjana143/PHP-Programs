<?php

// connect to MySQL
$conn = new mysqli("localhost", "root", "", "mysql");

// check connection
if (!$conn) {
  die("Connection failed: ");
}

// create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS demo_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  email VARCHAR(50))");

// insert data
if (isset($_POST['save'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $conn->query("INSERT INTO demo_users (name, email) VALUES ('$name', '$email')");
}

// fetch data
$result = $conn->query("SELECT * FROM demo_users");
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

