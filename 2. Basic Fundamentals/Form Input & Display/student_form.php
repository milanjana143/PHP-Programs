<!DOCTYPE html>
<html>
<head>
    <title>Student Details Form (POST Method)</title>
</head>
<body style="font-family: Arial; margin: 40px;">

    <h2>Student Details Form</h2>

    <!-- Form using POST method -->
    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="roll">Roll No:</label><br>
        <input type="text" name="roll" required><br><br>

        <label for="dept">Department:</label><br>
        <input type="text" name="dept" required><br><br>

        <input type="submit" name="submit" value="Submit Details">
    </form>

    <hr>

    <?php 
    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form data
        $name = htmlspecialchars($_POST['name']);
        $roll = htmlspecialchars($_POST['roll']);
        $dept = htmlspecialchars($_POST['dept']);

        // Display the submitted data
        echo "<h3>Student Information:</h3>";
        echo "Name: $name <br>";
        echo "Roll No: $roll <br>";
        echo "Department: $dept <br>";
    }
    ?>

</body>
</html>