<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form in PHP</title>
</head>
<body style="font-family: Arial; margin: 40px;">

    <h2>Feedback Form</h2>

    <!-- Feedback Form -->
    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="comments">Your Feedback:</label><br>
        <textarea name="comments" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" name="submit" value="Submit Feedback">
    </form>

    <hr>

    <?php 
    // Check if form is submitted
    if (isset($_POST['submit'])) { 
        // Fetch and sanitize form data
        $name = htmlspecialchars($_POST['name']); 
        $email = htmlspecialchars($_POST['email']); 
        $comments = htmlspecialchars($_POST['comments']); 

        // Display the feedback
        echo "<h3>Thank you for your feedback!</h3>"; 
        echo "Name: $name <br>"; 
        echo "Email: $email <br>"; 
        echo "Your Comments: <br>"; 
        echo "<p style='background:#f0f0f0; padding:10px; border-left:4px solid #666;'>$comments</p>"; 
    } 
    ?> 

</body>
</html>
