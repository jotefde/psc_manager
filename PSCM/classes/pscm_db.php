<?php
/****
***** @author Jakub Frydryk <jotefde.studio@gmail.com>
***** @copyright JoteFDe
***** @version: 1.0
*****/

if(!defined("ROOT_DIR") || !defined("PSCM_DIR") || !defined("PSCM_ADDR") )
{
    header("HTTP/1.0 404 Not Found");
    print('<h2>ERROR 404</h2>
        <em>Specified in the request address was not found on this server.</em>');
    exit;
}

class PSCM_DB {
    public static $sql;
    const TRANSFERS_TABLE = 'pscm_transfers';
    
    public static function setConnection( $_sql )
    {
        if( $_sql instanceof PDO )
        {
            self::$sql = $_sql;
        }
    }
    
    public static function connect($_host, $_user, $_pass, $_dbname, $warrnings = true) 
    {
        if(self::$sql instanceof PDO)
        {
            self::close();
            if($warrnings)
                trigger_error("Attempt to reconnect!");
        }
        
        try {
            self::$sql = new PDO("mysql:host=$_host;dbname=$_dbname;charset=utf8", $_user, $_pass);
        } catch (PDOException $ex) {
            if($warrnings)
                trigger_error("Cannot connect to MySQL: ".$ex->getMessage(), E_USER_ERROR);
            return $e;
        }
        return true;
    }

    public static function initTable()
    {
        $handle = fopen(PSCM_DIR.'configs/'.self::TRANSFERS_TABLE.'.sql', 'r');
	$query = trim(stream_get_contents($handle));
        self::query($query);
	fclose($handle);
    }

    public static function query($q = '')
    {        
        return self::$sql->query($q);
    }
    
    public static function exec($q = '')
    {
        return self::$sql->exec($q);
    }
    
    public static function prepare($q = '')
    {
        return self::$sql->prepare($q);
    }
    
    public static function lastInsertedId()
    {
        return self::$sql->lastInsertedId();
    }
    
    public static function close()
    {
        self::$sql = null;
    }
}
