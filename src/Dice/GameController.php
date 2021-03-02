<?php

namespace Aner\Dice;

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
class GameController implements AppInjectableInterface
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
        $session->set("game", new Game());
        $session->set("throw", null);
        $session->set("stop", null);

        // $data = [
        //     "game" => $game,
        //     "throw" => $throw ?? null,
        //     "stop" => $stop ?? null,
        // ];
    

        // $page->add("dice1/play");
        //$app->page->add("guess/debug");

        return $response->redirect("dice1/play");
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

        $game = $session->get("game");
        $throw = $session->get("throw");
        $stop = $session->get("stop");

        $session->set("throw", null);
        $session->set("stop", null);
        $session->set("game", $game);

        $data = [
            "game" => $game,
            "throw" => $throw ?? null,
            "stop" => $stop ?? null,
            "doThrow" => $doThrow ?? null,
            "doStop" => $doStop ?? null,
        ];

        $page->add("dice1/play", $data);
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
    
        $game = $session->get("game");

        $doThrow = $request->getPost("doThrow");
        $doStop = $request->getPost("doStop");

        if ($doThrow) {
            $throw = $game->throwDice();

            $session->set("throw", $throw);
        }

        if ($doStop) {
            $stop = $game->addHand();

            $session->set("throw", $stop);
        }

        return $response->redirect("dice1/play");
    }
}
