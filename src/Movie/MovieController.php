<?php

namespace Aner\Movie;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



     /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * This sample method dumps the content of $app.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpAppActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->app->getServices());
        return __METHOD__ . "<p>\$app contains: $services";
    }


    /**
     * This is the index method action
     *
     * @return object
     */
    public function showAction() : object
    {
        $title = "Filmdatabas";
        $page = $this->app->page;
        $db = $this->app->db;
        $movieClass = new Movie();
        $res = $movieClass->getAll($db);

        $page->add("movie/header");
        $page->add("movie/show-movies", [
            "res" => $res,
        ]);
        
        return $page->render([
            "title" => $title,
        ]);
    }


    public function titleAction() : object
    {
        $title = "Filmdatabas";
        $page = $this->app->page;
        $res = [];

        $page->add("movie/header");
        $page->add("movie/search-title", [
            "res" => $res,
            "search" => ""
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleActionPost() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $res = [];
        $movieClass = new Movie();

        $page->add("movie/header");

        $res = $movieClass->searchTitle($page, $request);
        $title = $res[2];

        $db->connect();
        $res = $db->executeFetchAll($res[0], $res[1]);

        $page->add("movie/show-movies", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function yearAction() : object
    {
        $title = "Filmdatabas";
        $page = $this->app->page;

        $page->add("movie/header");
        $page->add("movie/search-year", [
            "year1" => 1900,
            "year2" => 2100
        ]);
        
        return $page->render([
            "title" => $title,
        ]);
    }

    public function searchYearActionPost() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $res = [];
        $movieClass = new Movie();

        $page->add("movie/header");

        $res = $movieClass->searchYear($page, $request);
        $title = $res[2];

        $db->connect();
        $res = $db->executeFetchAll($res[0], $res[1]);

        $page->add("movie/show-movies", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function selectAction() : object
    {
        $title = "Filmdatabas";
        $db = $this->app->db;
        $page = $this->app->page;
        $movieClass = new Movie();

        $res = $movieClass->getAll($db);

        $page->add("movie/header");
        $page->add("movie/movie-select", [
            "res" => $res,
        ]);
        
        return $page->render([
            "title" => $title,
        ]);
    }

    public function selectActionPost() : object
    {
        $title = "Filmdatabas";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $response = $this->app->response;
        $res = [];
        $add = $request->getPost("doAdd");
        $edit = $request->getPost("doEdit");
        $del = $request->getPost("doDelete");
        $movie = $request->getPost("movieId");
        $movieClass = new Movie();
        
        $page->add("movie/header");
        $db->connect();

        if ($add) {
            // Add to edit
            $movie = $movieClass->add($db);
            $movie = $db->lastInsertId();
            $edit = true;
        }
        if ($movie && $edit) {
            // Edit "this" movie
            $res = $movieClass->edit($db, "edit", $movie);
            $page->add("movie/movie-edit", [
                "movie" => $res,
            ]);
        } elseif ($movie && $del) {
            // Delete "this" movie
            $movieClass->edit($db, "del", $movie);
            return $response->redirect("movie/select");
        } else {
            $page->add("movie/movie-select", [
                "res" => $res,
            ]);
        }

        return $page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {
        $title = "Editera databasen";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $response = $this->app->response;
        $movieClass = new Movie();

        $page->add("movie/header");

        $save = $request->getPost("doSave");
        $reset = $request->getPost("doReset");
        $movie = $request->getPost("movieId");

        $db->connect();

        if ($reset) {
            // Resets to current values in DB
            $res = $movieClass->resetMovie($db, $movie);
            $page->add("movie/movie-edit", [
                "movie" => $res,
            ]);
        } elseif ($save) {
            // Save new vakues to DB
            $movieClass->updateMovie($db, $request, $movie);
            return $response->redirect("movie/show");
        }

        return $page->render([
            "title" => $title,
        ]);
    }

    public function resetAction() : object
    {
        $title = "Återställ databas";
        $page = $this->app->page;

        $page->add("movie/header");
        $page->add("movie/reset");

        return $page->render([
            "title" => $title,
        ]);
    }

    public function resetActionPost() : object
    {
        $title = "Återställ databas";
        $db = $this->app->db;
        $page = $this->app->page;
        $page->add("movie/header");
        $db->connect();
        $movieClass = new Movie();
        $serverType = "";

        if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
            $serverType = "bth";
        }
        $dbConfig = $this->app->configuration->load("database")['config'];
        $output = $movieClass->reset($dbConfig, $serverType);
            $page->add("movie/reset", [
            "reset" => $output
            ]);

        return $page->render([
            "title" => $title,
        ]);
    }




    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }
}
