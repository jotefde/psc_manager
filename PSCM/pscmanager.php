<?php
/****
***** @author Jakub Frydryk <jotefde.studio@gmail.com>
***** @copyright JoteFDe
***** @version: 1.0
*****/

if( !defined("ROOT_DIR") )
    define( "ROOT_DIR", $_SERVER["DOCUMENT_ROOT"] );

if( !defined("PSCM_DIR") )
    $dir = str_replace ('\\', '/', __DIR__);
    define( "PSCM_DIR", $dir.'/' );

$protocol = $_SERVER["REQUEST_SCHEME"]."://";
if( !defined("PSCM_ADDR") )
    define( "PSCM_ADDR", $protocol.$_SERVER["SERVER_ADDR"].$_SERVER["REQUEST_URI"] );

$res = str_replace(ROOT_DIR, '', PSCM_DIR);

if( !defined("PSCM_URL") )
    define( "PSCM_URL", $protocol.$_SERVER["SERVER_ADDR"].'/'.$res );

if( !defined("PSCM_PUBLIC") )
    define( "PSCM_PUBLIC", $protocol.$_SERVER["SERVER_ADDR"].'/'.$res.'public/' );

    

require_once PSCM_DIR.'classes/pscm_feedback.php';

require_once PSCM_DIR.'classes/pscm_db.php';
require_once PSCM_DIR.'classes/pscm_service.php';

class PSCManager {
    
    private static $services,
                   $api_url,
                   $api_control,
                   $api_public_key,
                   $api_private_key,
                   $api_user_id,
                   $api_termination_url,
                   $api_currency;
    
    public static $feedback;
    
    public static function init()
    {
        
        self::loadSettings();
        PSCM_DB::initTable();
        
        self::$services = array();
        self::loadServices();
        if( !self::$feedback->status() )
        {
            trigger_error (self::$feedback->value());
            die;
        }
    }
    
    private static function loadSettings()
    {
        $file = PSCM_DIR.'configs/settings.inc.php';
        if(file_exists($file) )
        {
            require_once $file;
            if( is_array($SETTINGS) && is_array($pscm_sql) )
            {
                $found = 0;
                foreach( $SETTINGS as $key=>$value )
                if( property_exists('PSCManager', $key) )
                {
                    self::${$key} = $value;
                    $found++;
                }
            }
            if( $found != 7 )
            {
                self::$feedback = new PSCM_Feedback(False, "Lost setting value in 'configs/settings.inc.php'");
                return false;
            }

            if( $pscm_sql["pdo"] instanceof PDO)
                PSCM_DB::setConnection($pscm_sql["pdo"]);
            else
                PSCM_DB::connect($pscm_sql["host"], $pscm_sql["user"], $pscm_sql["password"], $pscm_sql["dbname"]);

            self::$feedback = new PSCM_Feedback(TRUE, "All is good! :)");
            return true;
        }
        self::$feedback = new PSCM_Feedback(FALSE, 'Array $SETTINGS does not exists in settings.inc.php!');
        return false;
    }

    private static function loadServices()
    {
        $file = PSCM_DIR.'configs/services.inc.php';
        if(file_exists($file) )
        {
            require_once $file;
            if( is_array($SERVICES) )
            {
                if( count($SERVICES) > 0 )
                {
                    foreach($SERVICES as $index => $service)
                    {
                        $added = self::addService($index, $service["price"], $service["premium_points"], $service["description"]);
                        if($added) continue;
                        
                        //If not added
                        self::$feedback = new PSCM_Feedback(FALSE, "Cannot load service with index '$index'!");
                        return false;
                    }
                    self::$feedback = new PSCM_Feedback(TRUE, "All is good! :)");
                    return true;
                }
                self::$feedback = new PSCM_Feedback(FALSE, "Not defined any service!");
                return false;
            }
            self::$feedback = new PSCM_Feedback(FALSE, 'Array $SERVICES does not exists in services.inc.php!');
            return false;
        }
        self::$feedback = new PSCM_Feedback(FALSE, "The file 'configs/services.inc.php' has been lost.");
        return false;
    }
        
    private static function addService( $_id, $_price, $_pp, $_desc )
    {
        $service = new PSCM_Service($_id, $_price, $_pp, $_desc);
        if( $service->feedback->status() )
        {
            array_push(self::$services, $service);
            return true;
        }
        trigger_error($service->feedback->value(), $service->feedback->etype());
        return false;
    }
    
    public static function prop($name) {
        if(property_exists("PSCManager", $name) )
        {
            return self::${$name};
        }
    }
    
    public static function getByIndex($id)
        {
            return ( array_key_exists($id, self::$services) ) ? self::$services[$id] : self::$services[0];
        }

    public static function getByUID($_uid)
    {
        if( !is_int($_uid) ) return false;
        for($i = 0; $i < count(self::$services); $i++)
        {
            if( self::$services[ $i ]->ID() == $_uid )
            {
                return self::$services[ $i ];
            }
        }
        return false;
    }
    
    public static function getByID($_id='')
    {
        for($i = 0; $i < count(self::$services); $i++)
        {
            if( self::$services[ $i ]->ID() == $_id )
            {
                return self::$services[ $i ];
            }
        }
        return false;
    }
    
    public static function count()
    {
        return count(self::$services);
    }
}
