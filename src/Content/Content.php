<?php

namespace Aner\Content;

/**
 * A class whith a few methods to access and update the database
 */
class Content
{

    /**
     * Get all content.
     *
     * @return object.
     */
    public function getAll($db)
    {
        $db->connect();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);
        return $res;
    }

    public function getAllBlogPost($db)
    {
        $db->connect();
        $sql = 'SELECT *, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%dT%TZ") AS published_iso8601, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%d") AS published FROM content WHERE type="post" AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW() ORDER BY published DESC ;';
        $res = $db->executeFetchAll($sql);
        return $res;        
    }

    public function getPost($db, $search, $column)
    {
        $db->connect();
        $sql = "SELECT * FROM content WHERE $column = ? AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW()";
        $res = $db->executeFetchAll($sql, [$search]);
        return $res;
    }

    public function getAllPages($db)
    {
        $db->connect();
        $sql = 'SELECT *, CASE WHEN (deleted <= NOW()) THEN "isDeleted" WHEN (published <= NOW()) THEN "isPublished" ELSE "notPublished" END AS status FROM content WHERE type=?;';
        $res = $db->executeFetchAll($sql, ["page"]);
        return $res;        
    }

    public function createPost($db, $title)
    {
        $db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($sql, [$title]);
    }

    public function savePost($db, $params)
    {
        $db->connect();
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        try {
            $db->execute($sql, array_values($params));
        } catch (\Anax\Database\Exception\Exception $e) {
            return $e;
        }   
    }

    public function deletePost($db, $id)
    {
        $db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $db->execute($sql, [$id]);
    }




    public function getValuePost($app, $column, $default = null)
    {
        if (is_array($column)) {
            foreach ($column as $val) {
                $post[$val] = $this->getValuePost($app, $val);
            }
            return $post;
        }

        return null != $app->request->getPost($column)
            ? $app->request->getPost($column)
            : $default;
    }

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
            $file = ANAX_INSTALL_PATH . '/sql/content/setup.sql';
            $mysql = '/usr/bin/mysql';
        } else {
            $file   = 'C:\Users\andre\dbwebb-kurser\oophp\me\redovisa\sql\content\setup.sql';
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
}
