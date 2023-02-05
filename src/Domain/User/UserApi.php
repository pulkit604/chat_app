<?php

namespace App\Domain\User;
use App\Application\Database\Database;
use PDO;

class UserApi
{
    private $connection;

    function __construct()
    {
        $this->connection = new Database();
        $this->connection = $this->connection->connect();
    }


    function createUser($first_name, $last_name, $username, $password) {
        try {
            $result = $this->connection->query("INSERT INTO user (first_name, last_name, username, password) VALUES ('{$first_name}', '{$last_name}', '{$username}', '{$password}')");
            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function loginUser($username, $password) {
        try {
            $result = $this->connection->query("SELECT id from user WHERE username = '{$username}', password = '{$password}'");
            $result->fetchAll(PDO::FETCH_BOTH);
            return rand(10, 100).$username;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function checkLoginToken($token) {
        try {
            $result = $this->connection->query("SELECT id from user WHERE login_token = '{$token}'");
            return $result->fetchAll(PDO::FETCH_BOTH);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function getLoginToken($username, $password) {
        $new_token = rand(10, 100).$username;
        try {
            $result = $this->connection->query("INSERT INTO user (login_token) VALUES ('{new_token}') WHERE username = '{$username}' and password = '{$password}'");
            return $result->fetchAll(PDO::FETCH_BOTH);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUserDetail($id) {
        try {
            $result = $this->connection->query("SELECT * FROM user WHERE id = '{$id}' limit 1;");
            return $result->fetchAll(PDO::FETCH_BOTH);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function storeMessage($text, $sender_id, $receiver_id) {
        try {
            $result = $this->connection->query("INSERT INTO message (text, sender_id, receiver_id) VALUES ('{$text}', '{$sender_id}', '{$receiver_id}'))");
            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function getMessages($receiver_id) {
        try {
            $result = $this->connection->query("'SELECT * FROM message");
            return $result->fetchAll(PDO::FETCH_BOTH);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function getMessageTeaser($receiver_id) {
        try {
            $result = $this->connection->query("SELECT * FROM message WHERE receiver_id = '{$receiver_id}'");
            return $result->fetchAll(PDO::FETCH_BOTH);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

    }

}
