<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Hangman Game</title>
    <link rel="stylesheet" href="styles.css">
    <?php include 'top.html'; ?> 
</head>
<body>

    <div class="container">

        <main>
            <h2>Contact Us</h2>
            <p>Feel free to reach out to us if you have any questions, feedback, or inquiries. We'll get back to you as soon as possible!</p>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];

                echo '<div class="message">Thank you for your message, ' . $name . '! We will get back to you soon.</div>';
            }
            ?>

            <form action="contact.php" method="post" class="contact-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </main>

    </div>

    <?php include("bottom.html"); ?>
</body>
</html>
