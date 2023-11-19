<?php include("top.html"); ?>

<?php
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    if (empty($username)) {
        $errors[] = "Username is required";
    } 
    if (empty($password)) {
        $errors[] = "Password is required";
    } 

// Read the file and check for the entered credentials
// $found = false;
// $file = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
// foreach ($file as $line) {
//     if (strpos($line, 'Username:') === 0) {
//         $parts = explode(":", $line, 2);
//         $storedUser = trim($parts[1]);

//         // Get the next line which contains the password
//         $passwordLine = next($file);
//         $storedPassword = trim(explode(":", $passwordLine, 2)[1]);

//         if ($username === $storedUser && $password === $storedPassword) {
//             // Username and password match
//             $found = true;
//             break;
//         }
//     }
// }

if (empty($errors)) {
    // Read the file and check for the entered credentials
    $found = false;
    $file = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $credentials = array_chunk($file, 2); // Group lines into pairs of username and password

    foreach ($credentials as $credential) {
        $storedUser = trim(str_replace('Username:', '', $credential[0]));
        $storedPassword = trim(str_replace('Password:', '', $credential[1]));

        if ($username === $storedUser && $password === $storedPassword) {
            $found = true;
            break;
        }
    }
}
if(empty($errors) && !$found){
    $errors[] = "Invalid username or password";
}
if (empty($errors) && $found) {
    header('Location: game.php');
    exit();
} 

}
?>
<br>
<br>
<div class="container">
    <form action="login.php" method="post">
        <fieldset>
            <legend>User Login:</legend>

            <?php
            if (!empty($errors)) {
                echo '<div class="errors"><p>Please fix the following errors:</p><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul></div>';
            }
            ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" size="17" maxlength="16"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" size="17" maxlength="16"><br><br>

            <input type="submit" value="Log In">
        </fieldset>
    </form>
</div>

<?php include("bottom.html"); ?>
