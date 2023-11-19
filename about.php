<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hangman Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php
    include("top.html");

    $username = isset($_COOKIE['hangman_username']) ? $_COOKIE['hangman_username'] : null;
    ?>

    <div class="container">

        <main>
            <h2>About</h2>
            <p>Welcome to the Hangman Game! This is a simple and fun game where you can test your word-guessing skills.</p>
            <p>Learn more about how the game works and enjoy playing!</p>

            <?php
            if ($username) {
                echo "<p>Hello, $username! Thanks for playing Hangman!</p>";
            }
            ?>

            <!-- Additional Information -->
            <h3>Contact Information</h3>
            <p>Address: 456 Game Street, Fun City, Downtown Atlanta</p>
            <p>Phone: +1 678-123-4567</p>

            <!-- Google Map -->
            <h3>Location on Map</h3>
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3309.602836534984!2d-84.38801368468091!3d33.74993568067845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f5045d69938b1d%3A0x5f2404765557d191!2sDowntown%20Atlanta!5e0!3m2!1sen!2sus!4v1661349132705!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
            <img src="map.png">
            </main>

    </div>

    <?php include 'bottom.html'; ?>

</body>
</html>
