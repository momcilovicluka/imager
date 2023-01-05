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

    public function getImages()
    {
        try {
            $sql = "SELECT * FROM " . "image";
            $st = $this->conn->prepare($sql);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }

    public function getImagesUser($username)
    {
        try {
            $sql = "SELECT * FROM " . "image" . " WHERE " . "username" . "=:username";
            $st = $this->conn->prepare($sql);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }

    public function checkLogin($username, $password)
    {
        try {
            echo $username;
            echo $password;
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

    public function insertImage($title, $username, $image)
    {
        try {
            $sql_existing_image = "SELECT * FROM " . "Image" . " WHERE " . "title" . "= :title and " . "username" . "= :username";
            $st = $this->conn->prepare($sql_existing_image);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->bindValue(":title", $title, PDO::PARAM_STR);
            $st->execute();
            if ($st->fetch()) {
                return false;
            }

            $sql = "INSERT INTO " . "image" . " ("."title".","
                                                          ."username".","
                                                          ."image".")"
                          ."VALUES (:title, :username, :image)";
            
            $st = $this->conn->prepare($sql);
            $st->bindValue("title", $title, PDO::PARAM_STR);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("image", $image, PDO::PARAM_STR);
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}