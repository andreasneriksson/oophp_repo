<?php

namespace Aner\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;
use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";


     /**
     * Index actions
     */
    public function indexAction() : object
    {   
        $title = "Allt innehåll";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);

        $res = $contentClass->getAll($db);

        $page->add("content/header");
        $page->add("content/index", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title ,
        ]);
    }

    /**
     * Admin actions
     */
    public function adminAction() : object
    {   
        $title = "Administration";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);

        $res = $contentClass->getAll($db);

        $page ->add("content/header");
        $page ->add("content/admin", [
            "res" => $res,
        ]);

        return $page ->render([
            "title" => $title,
        ]);
    }

    public function editActionGet($id) : object
    {   
        $title = "Editera";
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $contentClass = new Content($db);

        $res = $contentClass->getPost($db, $id, "id");

        if (!$res) {
            throw new NotFoundException();
        }

        $errormessage = $session->get("errormessage");

        $page->add("content/header");
        $page->add("content/edit", [
            "res" => $res,
            "errormessage" => $errormessage,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {   
        $db = $this->app->db;
        $response = $this->app->response;
        $session = $this->app->session;
        $contentClass = new Content($db);

        $params = $contentClass->getValuePost($this->app, [
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        if (!$params["contentSlug"]) {
            $params["contentSlug"] = null;
        }

        $error = $contentClass->savePost($db, $params);
        if ($error) {
            $session->set("errormessage", true);
        }

        return $response->redirect("content/edit/" . $params["contentId"]);
    }

    public function deleteActionGet($id) : object
    {   
        $title = "Radera";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);

        $res = $contentClass->getPost($db, $id, "id");

        if (!$res) {
            throw new NotFoundException();
        }

        $page->add("content/header");
        $page->add("content/delete", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function deleteActionPost() : object
    {   
        $db = $this->app->db;
        $response = $this->app->response;
        $contentClass = new Content($db);

        $id = $contentClass->getValuePost($this->app, "contentId");

        $contentClass->deletePost($db, $id);

        return $response->redirect("content/admin");
    }

    /**
     * Blog actions
     */
    public function blogAction() : object
    {   
        $title = "Alla blogginlägg";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);
        $res = $contentClass->getAllBlogPost($db);

        $page->add("content/header");
        $page->add("content/blog", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function blogPostActionGet($slug) : object
    {   
        $title = "Blogpost";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);

        $res = $contentClass->getPost($db, $slug, "slug");

        if (!$res) {
            throw new NotFoundException();
        }

        $page->add("content/header");
        $page->add("content/blogpost", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Pages actions
     */
    public function pagesAction() : object
    {   
        $title = "Alla sidor";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);
        $res = $contentClass->getAllPages($db);
        $page->add("content/header");
        $page->add("content/pages", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function pageActionGet($path) : object
    {   
        $title = "Page";
        $db = $this->app->db;
        $page = $this->app->page;
        $contentClass = new Content($db);

        $res = $contentClass->getPost($db, $path, "path");
        
        if (!$res) {
            throw new NotFoundException();
        }
 
        $page->add("content/header");
        $page->add("content/page", [
            "res" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Create actions
     */
    public function createActionGet() : object
    {   
        $title = "Skapa";
        $page = $this->app->page;

        $page->add("content/header");
        $page->add("content/create");

        return $page->render([
            "title" => $title,
        ]);
    }

    public function createActionPost() : object
    {   
        $db = $this->app->db;
        $response = $this->app->response;
        $contentClass = new Content($db);

        $title = $contentClass->getValuePost($this->app, "contentTitle");

        $contentClass->createPost($db, $title);
        $id = $db->lastInsertId();

        return $response->redirect("content/edit/$id");
    }

    /**
     * Reset actions
     */
    public function resetAction() : object
    {
        $title = "Återställ databas";
        $page = $this->app->page;

        $page->add("content/header");
        $page->add("content/reset");

        return $page->render([
            "title" => $title,
        ]);
    }

    public function resetActionPost() : object
    {
        $title = "Återställ databas";
        $db = $this->app->db;
        $page = $this->app->page;
        $page->add("content/header");
        $db->connect();
        $contentClass = new Content($db);
        $serverType = "";

        if ($_SERVER["SERVER_NAME"] === "www.student.bth.se") {
            $serverType = "bth";
        }
        $dbConfig = $this->app->configuration->load("database")['config'];
        $output = $contentClass->reset($dbConfig, $serverType);
            $page->add("content/reset", [
            "reset" => $output
            ]);

        return $page->render([
            "title" => $title,
        ]);
    }
}
