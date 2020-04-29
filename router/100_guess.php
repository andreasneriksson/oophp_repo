<?php

include dirname(__FILE__).'/../vendor/autoload.php';

/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start.
    $game = new \Aner\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";


    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;
    $guess = $_SESSION["guess"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["cheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "res" => $res,
        "cheat" => $cheat,
        "tries" => $tries,
        "number" => $number ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";
    
    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $doInit = $_POST["doInit"] ?? null;

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;

    if ($doGuess) {
        $game = new Aner\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);

        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }

    if ($doCheat) {
        $game = new Aner\Guess\Guess($number, $tries);
        
        $_SESSION["tries"] = $game->tries();
        $_SESSION["cheat"] = $number;
    }

    if ($doInit) {
        $game = new \Aner\Guess\Guess();
        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->tries();
    }

    return $app->response->redirect("guess/play");
});
