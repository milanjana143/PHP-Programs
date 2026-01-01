<html>
  <head>
    <title>LCM</title>
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
    $x = $a;
    $y = $b;

    while ($y != 0) {
        $t = $y;
        $y = $x % $y;
        $x = $t;
    }
    $gcd = $x;
    $lcm = ($a * $b) / $gcd;

    echo "LCM = " . $lcm;
    }
    ?>

</body>
</html>