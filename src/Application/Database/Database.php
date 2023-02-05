<?php

namespace App\Application\Database;

use PDO;

class Database
{
    public function connect()
    {
        $dbFile = 'chat_main_db.db';
        $pdo = new PDO("sqlite:$dbFile");
        print(json_encode($pdo));
        return $pdo;
    }
}
