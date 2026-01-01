<!DOCTYPE html>
<html>
<head>
    <title>Display User Information</title>
</head>
<body style="font-family: Arial; margin: 40px;">
    <h2>User Details</h2>
    <?php 
    if (isset($_GET['name']) && isset($_GET['age'])) {
        $name = htmlspecialchars($_GET['name']);
        $age = htmlspecialchars($_GET['age']);
        echo "Name: $name <br>";
        echo "Age: $age <br>";
    } else {
        echo "No data received!";
    }
    ?>
</body>
</html>
