<?php
function initializeHangmanGame($word) {
    $gameState = array(
        'word_to_guess' => strtoupper($word),
        'correct_guesses' => array(),
        'incorrect_guesses' => array(),
        'tries_left' => 6, 
        'word_guessed' => false
    );
    return $gameState;
}
function checkGuess($letter, $word) {
    return stripos($word, $letter) !== false;
}
function updateHangmanGameState($guessedLetter, $gameState) {
    $wordToGuess = $gameState['word_to_guess'];
    $correctGuess = checkGuess($guessedLetter, $wordToGuess);

    if ($correctGuess) {
        $gameState['correct_guesses'][] = $guessedLetter;

        $wordArray = str_split($wordToGuess);
        foreach ($wordArray as $char) {
            if (!in_array($char, $gameState['correct_guesses'])) {
                return $gameState;
            }
        }
        $gameState['word_guessed'] = true;
    } else {
        $gameState['incorrect_guesses'][] = $guessedLetter;
        $gameState['tries_left']--;

        if ($gameState['tries_left'] === 0) {
            $gameState['word_guessed'] = false;
        }
    }
    return $gameState;
}
function displayHangmanWord($word, $correctGuesses) {
    $display = '';
    $wordArray = str_split($word);

    foreach ($wordArray as $char) {
        if (in_array($char, $correctGuesses)) {
            $display .= $char . ' ';
        } else {
            $display .= '_ ';
        }
    }
    return trim($display);
}

?>

<?php
include("top.html"); 

session_start();

$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$WON = false;


$guess = "HANGMAN";
$maxLetters = strlen($guess) - 1;
$responses = ["H","G","A"];

$bodyParts = ["nohead","head","body","hand","hands","leg","legs"];


$words = [
   "GSU", "BUTTERFLY" , "APPLE", "CODE", "DUPLICATE",
    "ATLANTA", "WEB"
];
function getCurrentPicture($part){
    return "./images/hangman_". $part. ".png";
}
function startGame(){
   
}
function restartGame(){
    session_destroy();
    session_start();

}
function getParts(){
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}
function addPart(){
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

function getCurrentPart(){
    $parts = getParts();
    return $parts[0];
}
function getCurrentWord(){
  //  return "HANGMAN"; // for now testing
    global $words;
    if(!isset($_SESSION["word"]) && empty($_SESSION["word"])){
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getCurrentResponses(){
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter){
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}
function isLetterCorrect($letter){
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for($i=0; $i<= $max; $i++){
        if($letter == $word[$i]){
            return true;
        }
    }
    return false;
}

function isWordCorrect(){
    $guess = getCurrentWord();
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for($i=0; $i<= $max; $i++){
        if(!in_array($guess[$i],  $responses)){
            return false;
        }
    }
    return true;
}
function isBodyComplete(){
    $parts = getParts();
    if(count($parts) <= 1){
        return true;
    }
    return false;
}
function gameComplete(){
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] :false;
}


function markGameAsComplete(){
    $_SESSION["gamecomplete"] = true;
}
function markGameAsNew(){
    $_SESSION["gamecomplete"] = false;
}

if(isset($_GET['start'])){
    restartGame();
}
if(isset($_GET['kp'])){
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    
    if($currentPressedKey 
    && isLetterCorrect($currentPressedKey)
    && !isBodyComplete()
    && !gameComplete()){
        
        addResponse($currentPressedKey);
        if(isWordCorrect()){
            $WON = true; 
            markGameAsComplete();
        }
    }else{
        
        if(!isBodyComplete()){
           addPart(); 
           if(isBodyComplete()){
               markGameAsComplete(); 
           }
        }else{
            markGameAsComplete(); 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hangman The Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<br>
<br>
    <div class="main-app">
        <div class="image-container">
            <img class="hangman-image" src="<?php echo getCurrentPicture(getCurrentPart());?>" />

            <?php if(gameComplete()): ?>
                <h1 class="game-complete">GAME COMPLETE</h1>
                <?php if($WON && gameComplete()): ?>
                    <p class="game-status">WINNER! 😊</p>
                <?php elseif(!$WON && gameComplete()): ?>
                    <p class="game-status-lost">LOST  😞</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="info-container">
            <div class="letter-buttons">
                <form method="get">
                    <?php
                        $max = strlen($letters) - 1;
                        for($i=0; $i<= $max; $i++):
                    ?>
                        <button type="submit" name="kp" value="<?= $letters[$i] ?>">
                            <?= $letters[$i] ?>
                        </button>
                        <?php if ($i % 7 == 0 && $i>0): ?>
                            <br>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <br><br>
                    <button type="submit" name="start" class="restart-button">Restart Game</button>
                </form>
            </div>
        </div>
        <div class="cta-buttons">
        <a href="leaderboard.php" class="cta-button">
            Leaderboard
        </a>
        <div class="current-guesses">
            <?php
            $guess = getCurrentWord();
            $maxLetters = strlen($guess) - 1;
            for($j=0; $j<= $maxLetters; $j++):
                $l = getCurrentWord()[$j];
            ?>
                <?php if(in_array($l, getCurrentResponses())): ?>
                    <span class="current-guess"><?= $l ?></span>
                <?php else: ?>
                    <span class="current-guess">&nbsp;&nbsp;&nbsp;</span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <?php include("bottom.html"); ?>
</body>
</html>
