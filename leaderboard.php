<?php include("top.html"); ?>
<br>
<br>
<?php
// Read the leaderboard file
$leaderboardData = file('leaderboard.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Create an array to store username and scores
$scores = [];

// Parse each line to separate username and score
foreach ($leaderboardData as $line) {
    list($username, $score) = explode(':', $line);
    $scores[$username] = $score;
}

// Sort scores in descending order
arsort($scores);
?>

<!-- Display Leaderboard -->
<div class="centered">
<h1>Leaderboard</h1>
</div>
<div class="centered">
<ol style="color:white;list-style-position: inside;padding-right:50px;">
    <?php foreach ($scores as $username => $score) : ?>
        <li class="centered"><?= $username ?> - <?= $score ?></li>
    <?php endforeach; ?>
</ol>
</div>
<?php include("bottom.html"); ?>