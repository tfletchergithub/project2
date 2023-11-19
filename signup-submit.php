<?php include("top.html"); ?>
<?php
$errors = array();
$user = array(
    'name' => '',
    'username' => '',
    'password' => '',
);

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];

if(empty($name)){
    $errors[] = "Name cannot be empty.";
}
if(empty($username)){
    $errors[] = "Username cannot be empty.";
}
if(empty($password)){
    $errors[] = "Password cannot be empty.";
}
if (empty($errors)) {
    $existingUsernames = array();
    $file = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($file as $line) {
        if (strpos($line, 'Username:') === 0) {
            $parts = explode(":", $line, 2);
            $existingUsernames[] = trim($parts[1]);
        }
    }

    if (in_array($username, $existingUsernames)) {
        $errors[] = "Username already exists.";
    }
}

// If no errors, proceed to write data to file
if (empty($errors)) {
    $usertxt = urlencode($username);
    $passwordtxt = urlencode($password);
    $userData = "Username: $usertxt\nPassword: $passwordtxt\n\n";

    $file = fopen("users.txt", "a");
    fwrite($file, $userData);
    fclose($file);
}


if(isset($name)) {
    $user['name'] = urlencode($name);
}

if(isset($username)) {
    $user['username'] = urlencode($username);
}
if(isset($password)) {
    $user['password'] = urlencode($password);
}
if (preg_match("/[0-9]/", $name) === 1) {
    $errors[] = "Name cannot be digits";
}

$words = explode(" ", $user["name"]);
for ($i = 0; $i < count($words); $i++) {
    if(strcmp(ucfirst($words[$i]),$words[$i]) !== 0) {
        $errors[] = "Name must be capitalized";
        break;
    }
}
// if (!is_numeric($user["age"])) {
//     $errors[] = "Age is not a number.";
// }

?>
<div class="container">
    <?php if (empty($errors)) : ?>
        <pre class="success-message">
            Thank you
            Welcome to Hangman, <?= $user["name"] ?>!
            Now <a href="login.php">log in to Play!</a>
        </pre>
    <?php else : ?>
        <div class="errors">
            <p>Please fix the following errors:</p>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php include("bottom.html"); ?>
