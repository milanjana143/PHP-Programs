<html>
  <head>
    <title>Armstrong</title>
  </head>
<body>
    
    <form method="POST">
        Enter Number: <input type="number" name="num">
        <input type="submit" name="submit">
    </form>


    <?php
      if (isset($_POST['submit'])) {
        $n = $_POST['num'];
        $sum = 0;
        $temp = $n;

        while ($temp > 0) {
            $r = $temp % 10;
            $sum += $r * $r * $r;
            $temp = (int)($temp / 10);
        }

        if ($sum == $n)
            echo "Armstrong Number";
        else
            echo "Not an Armstrong Number";
    }
    ?>

</body>
</html>