<?php
/**
 * filename	: database.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program creates the connection to the database. 
 *			  Then the program submits queries to the database.
 * design	: 
 *			
 *			1. Authenticate the connect 
 *			2. Submit Query
 *			
*/ 

class Database
{
    private static $dbName = 'dmroof' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'dmroof';
    private static $dbUserPassword = '519049';

    private static $cont  = null;
    public function __construct() {
        die('Init function is not allowed');
    }
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
        }
        catch(PDOException $e)
        {
          die($e->getMessage());
        }
       }
       return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
