<html>
  <head>
    <title>GCD</title>
  </head>
<body>
    
    <form method="post">
    Num1: <input type="number" name="a"><br><br>
    Num2: <input type="number" name="b"><br><br>
    <input type="submit" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
    $a = $_POST['a'];
    $b = $_POST['b'];

    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    echo "GCD = " . $a;
    }
    ?>

</body>
</html>