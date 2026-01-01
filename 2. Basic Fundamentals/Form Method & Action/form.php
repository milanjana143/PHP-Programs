<!DOCTYPE html>
<html>
<head>
    <title>User Information Form (GET Method)</title>
</head>
<body style="font-family: Arial; margin: 40px;">
    <h2>Enter Your Details</h2>
    <form method="get" action="display.php">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label for="age">Age:</label><br>
        <input type="number" name="age" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
