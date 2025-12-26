<html>
<head>
    <title>Fibonacci</title>
</head>
<body>
<form method="post">
    Enter number of terms: <input type="number" name="n" required><br><br>
    <input type="submit" name="submit" value="Generate">
</form>
<?php
if ($_POST) {
    $n = $_POST['n'];
    $a = 0;
    $b = 1;
    echo "<br>Fibonacci Series: ";
    for ($i = 1; $i <= $n; $i++) {
        echo $a . " ";
        $c = $a + $b;
        $a = $b;
        $b = $c;
    }
}
?>
</body>
</html>