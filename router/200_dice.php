<?php

include dirname(__FILE__).'/../vendor/autoload.php';

/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the game start.
    $_SESSION["game"] = new \Aner\Dice\Game();
    $_SESSION["throw"] ?? null;
    $_SESSION["stop"] ?? null;
    
    return $app->response->redirect("dice/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"] ?? null;
    $throw = $_SESSION["throw"] ?? null;
    $stop = $_SESSION["stop"] ?? null;

    $_SESSION["throw"] = null;
    $_SESSION["stop"] = null;

    $data = [
        "game" => $game,
        "throw" => $throw ?? null,
        "stop" => $stop ?? null,
        "doThrow" => $doThrow ?? null,
        "doStop" => $doStop ?? null,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make guess
 */
$app->router->post("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"] ?? null;
    $doThrow = $_POST["doThrow"] ?? null;
    $doStop = $_POST["doStop"] ?? null;

    if ($doThrow) {
        $throw = $game->throwDice();

        $_SESSION["throw"] = $throw;
    }

    if ($doStop) {
        $stop = $game->addHand();
        
        $_SESSION["stop"] = $stop;
    }

    return $app->response->redirect("dice/play");
});
