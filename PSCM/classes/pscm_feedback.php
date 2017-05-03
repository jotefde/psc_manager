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

class PSCM_Feedback
{
    private $status,
            $value,
            $e_type;
    
    public function __construct($_status, $_value, $_e_type=E_USER_NOTICE) {
        if( (!is_int($_status) && !is_bool($_status)) || empty($_value) )
            return false;
        
        $this->status = $_status;
        $this->value = $_value;
        $this->e_type = $_e_type;
    }
    
    public function status() { return $this->status; }
    public function value() { return $this->value; }
    public function etype() { return $this->e_type; }
}