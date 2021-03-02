<?php

namespace Aner\Movie;

/**
 * Class to work with movie controller.
 */
class Movie
{

    /**
     * Reset the database with sql file local or on bth server.
     *
     * @param array $config details on how to connect.
     *
     * @return string
     *
     */
    public function reset($dbConfig, $serverType)
    {
        if ($serverType === "bth") {
            $file = ANAX_INSTALL_PATH . '/sql/movie/setup.sql';
            $mysql = '/usr/bin/mysql';
        } else {
            $file   = 'C:\Users\andre\dbwebb-kurser\oophp\me\redovisa\sql\movie\setup.sql';
            $mysql  = 'C:\xampp\mysql\bin\mysql.exe';
        }
        $dsnDetail = [];
        preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $dbConfig["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $database = $dsnDetail[2];
        $login = $dbConfig["username"];
        $password = $dbConfig["password"];
        $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
        $output = [];
        $status = null;
        $res = exec($command, $output, $status);
        $output = "<p>The command was: <code>$command</code>.<br>The command exit status was $status."
            . "<br>The output from the command was:</p><pre>"
            . print_r($output, 1);
        return $output;
    }

    /**
     * Edit or delete movie in DB.
     *
     * @return object.
     */
    public function edit($db, $type, $movie)
    {
        if ($type === "edit") {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $param = [$movie];
            $res = $db->executeFetch($sql, $param);
            return $res;
        } elseif ($type === "del") {
            $sql = "DELETE FROM movie WHERE id = ?";
            $params = [$movie];
            $db->execute($sql, $params);
        }
    }

    /**
     * Add to add selection.
     *
     * @return bool.
     */
    public function add($db)
    {
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->execute(
            $sql,
            ["Title", 2000, "img/noimage.png"]
        );

        return $db->lastInsertId();
    }

    /**
     * Search Year or title.
     *
     * @return array.
     */
    public function searchYear($page, $request)
    {
        $res = [];

        $title = "Sök filmer efter år";
        $year1 = $request->getPost("year1");
        $year2 = $request->getPost("year2");
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $params = [$year1, $year2];
        $page->add("movie/search-year", [
            "res" => $res,
            "year1" => $year1,
            "year2" => $year2,
        ]);
        return [$sql, $params, $title];
    }

    /**
     * Search Year or title.
     *
     * @return array.
     */
    public function searchTitle($page, $request)
    {
        $res = [];
        $title = "Sök på filmtitlar";
        $search = $request->getPost("search");
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $params = [$search];
        $page->add("movie/search-title", [
            "res" => $res,
            "search" => $search
        ]);
        return [$sql, $params, $title];
    }

    /**
     * Get all movies.
     *
     * @return object.
     */
    public function getAll($db)
    {
        $db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Update a movie.
     *
     * @return void.
     */
    public function updateMovie($db, $request, $movie)
    {
        $year = $request->getPost("movieYear");
        $title = $request->getPost("movieTitle");
        $img = $request->getPost("movieImage");
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?";
        $params = [$title, $year, $img, $movie];
        $db->execute($sql, $params);
    }

    /**
     * Get data of specific movie.
     *
     * @return object.
     */
    public function resetMovie($db, $movie)
    {
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $param = [$movie];
        $res = $db->executeFetch($sql, $param);
        return $res;
    }
}
