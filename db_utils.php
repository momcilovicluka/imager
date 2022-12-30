<?php

class Database
{
    private $hashing_salt = "dsaf7493^&$(#@Kjh";

    private $conn;

    public function __construct($configFile = "config.ini")
    {
        if ($config = parse_ini_file($configFile)) {
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    function insertUser($username, $password, $name)
    {
        try {
            $sql_existing_user = "SELECT * FROM " . "User" . " WHERE " . "username" . "= :username";
            $st = $this->conn->prepare($sql_existing_user);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            if ($st->fetch()) {
                return false;
            }
            
            $hashed_password = crypt($password, $this->hashing_salt);

            $sql_insert = "INSERT INTO " . "User" . " ("."username".","
                                                          ."password".","
                                                          ."name".")"
                        ." VALUES (:username, :password, :name)";

            $st = $this->conn->prepare($sql_insert);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("password", $hashed_password, PDO::PARAM_STR);
            $st->bindValue("name", $name, PDO::PARAM_STR);
            
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPosts($userId)
    {
        try {
            $sql = "SELECT * FROM " . TBL_POST . " WHERE " . COL_POST_USERID . "=:user";
            $st = $this->conn->prepare($sql);
            $st->bindValue("user", $userId, PDO::PARAM_INT);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }

    public function checkLogin($username, $password)
    {
        try {
            $hashed_password = crypt($password, $this->hashing_salt);
            $sql = "SELECT * FROM " . "User" . " WHERE " . "username" . "=:username and " . "password" . "=:password";
            $st = $this->conn->prepare($sql);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("password", $hashed_password, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertPost($content, $userId)
    {
        try {
            $sql = "INSERT INTO " . TBL_POST . " (".COL_POST_TIME.","
                                                          .COL_POST_CONTENT.","
                                                          .COL_POST_USERID.")"
                          ."VALUES (:time, :content, :userId)";
            
            $time = date("d.m.Y H:i:s");
            
            $st = $this->conn->prepare($sql);
            $st->bindValue("time", $time, PDO::PARAM_STR);
            $st->bindValue("content", $content, PDO::PARAM_STR);
            $st->bindValue("userId", $userId, PDO::PARAM_INT);
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

}