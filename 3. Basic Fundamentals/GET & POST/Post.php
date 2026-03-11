<html>
  <head>
    <title>Post Form</title>
  </head>
<body>
    
    <form method="post">
    Name: <input type="text" name="name"><br><br>
    Roll No: <input type="text" name="roll"><br><br>
    Department: <input type="text" name="dept"><br><br>
    <input type="submit" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
    echo "Name: ".$_POST['name']."<br>";
    echo "Roll No: ".$_POST['roll']."<br>";
    echo "Department: ".$_POST['dept'];
    }
    ?>


</body>
</html>