<html>
    <head>
        <title>Get Show</title>
    </head>
<body>    
    <?php
        if(isset($_GET['submit'])){
            $a=($_GET['name']);
            $b=($_GET['age']);
        }

        echo $a . "<br>";
        echo $b . "<br>";

    ?>
</body>
</html>