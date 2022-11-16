<?php

  class Database
  {
    private static $hostname;
    private static $dbname;
    private static $username;
    private static $password;
    private static $pdo;

		public static function connect(){
      self::$hostname = 'localhost';
      self::$dbname = 'phprest';
      self::$username = 'root';
      self::$password = '';

      if(self::$pdo == null){
          try{
            self::$pdo = new \PDO('mysql:host='.self::$hostname.';dbname='.self::$dbname,self::$username,self::$password,array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
          }catch(Exception $e){
            echo json_encode('erro ao conectar');
            error_log($e->getMessage());
          }
        }
        return self::$pdo;
      }

      
    }
    $conn = Database::connect();
?>