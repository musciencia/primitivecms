<?php
 // TODO: Simplify Database
//       Saving of data should be handled inside each individual class
class Database
{
    private static $pdo;

    public static function connect()
    {
        $host = DB_HOST;
        $db = DB_NAME;
        $password = DB_PASSWORD;
        $charset = DB_CHARSET;
        $user = DB_USER;

        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
        $options[PDO::ATTR_EMULATE_PREPARES] = false;
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            self::$pdo = new PDO($dsn, $user, $password, $options);
            return self::$pdo;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            // throw new PDOException($e->getMessage(), (int)$e->getCode());
            return false;
        }
    }

    public static function getConnection()
    {
        return self::$pdo;
    }

    public static function getTableNames()
    {
        $sql = 'SHOW TABLES';
        $query = self::$pdo->query($sql);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function tablesExist($tableNames)
    {
        $tableNames = self::getTableNames();
        $exist = true;
        foreach ($tableNames as $table) {
            if ( !in_array($table, $tableNames) ) {
                $exist = false;
            }
        }
        return $exist;
    }

   
}
