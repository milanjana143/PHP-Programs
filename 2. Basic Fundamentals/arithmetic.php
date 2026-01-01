<!DOCTYPE html>
<html>
<head>
    <title>Arithmetic Operations in PHP</title>
</head>
<body style="font-family: Arial; margin: 50px;">

    <h2>Arithmetic Operations Using PHP</h2>

    <form method="post" action="">
        <label>Enter First Number:</label>
        <input type="number" name="num1" required><br><br>

        <label>Enter Second Number:</label>
        <input type="number" name="num2" required><br><br>

        <input type="submit" name="calculate" value="Calculate">
    </form>

    <hr>

    <?php 
    if (isset($_POST['calculate'])) {
        // Fetching input values
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];

        // Performing arithmetic operations
        $sum = $num1 + $num2;
        $diff = $num1 - $num2;
        $prod = $num1 * $num2;

        // Handling division by zero
        if ($num2 != 0) {
            $quot = $num1 / $num2;
        } else {
            $quot = "Undefined (Division by Zero)";
        }

        // Displaying results
        echo "<h3>Results:</h3>";
        echo "Sum = $sum <br>";
        echo "Difference = $diff <br>";
        echo "Product = $prod <br>";
        echo "Quotient = $quot <br>";
    }
    ?>

</body>
</html>