<?php

namespace Aner\Guess;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GuessController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";

    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "INDEX!!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;
        // Init the session for the game start.
        $game = new Guess();
        $session->set("number", $game->number());
        $session->set("tries", $game->tries());

        return $response->redirect("guess1/play");
    }


        /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game";
        $page = $this->app->page;
        $session = $this->app->session;

        $tries = $session->get("tries");
        $res = $session->get("res");
        $cheat = $session->get("cheat");
        $guess = $session->get("guess");

        $session->set("res", null);
        $session->set("guess", null);
        $session->set("cheat", null);

        $data = [
            "guess" => $guess ?? null,
            "res" => $res,
            "cheat" => $cheat,
            "tries" => $tries,
            "number" => $number ?? null,
            "doGuess" => $doGuess ?? null,
            "doCheat" => $doCheat ?? null,
        ];

        $page->add("guess1/play", $data);
        //$app->page->add("guess/debug");

        return $page->render([
            "title" => $title,
        ]);
    }



        /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;
    
        $guess = $request->getPost("guess");
        $doGuess = $request->getPost("doGuess");
        $doCheat = $request->getPost("doCheat");
        $doInit = $request->getPost("doInit");

        $number = $session->get("number");
        $tries = $session->get("tries");

        if ($doGuess) {
            $game = new Guess($number, $tries);
            $res = $game->makeGuess($guess);

            $session->set("tries", $game->tries());
            $session->set("res", $res);
            $session->set("guess", $guess);
        }

        if ($doCheat) {
            $game = new Guess($number, $tries);

            $session->set("tries", $game->tries());
            $session->set("cheat", $number);
        }

        if ($doInit) {
            $game = new Guess();
            $session->set("number", $game->number());
            $session->set("tries", $game->tries());
        }

        return $response->redirect("guess1/play");
    }
}
