<?php

include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("aner19");
session_start();

if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
}

$game = $_SESSION["guess"];
$guess = $_POST["guess"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$doInit = $_POST["doInit"] ?? null;

?>
<?php
$title = "Andreas | GUESS GAME";
include("view/header.php");
include("view/guess.php");
?>

<?php 
if ($doInit) {
    $_SESSION = [];
}
include("view/footer.php");
