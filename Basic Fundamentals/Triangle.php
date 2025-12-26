<html>
  <head>
    <title>Triangle</title>
  </head>
<body>
    
    <form method="post">
    Base: <input type="number" name="b"><br><br>
    Height: <input type="number" name="h"><br><br>
    <input type="submit" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
    $area = 0.5 * $_POST['b'] * $_POST['h'];
    echo "Area = " . $area;
    }
    ?>

</body>
</html>