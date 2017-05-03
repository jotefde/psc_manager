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

class PSCM_Service {
    
    private $id,
            $price,
            $premium_points,
            $description;
    
    public $feedback;
    
    public function __construct( $_id, $_price, $_pp, $_desc) {
        if( !is_int($_id) )
            $this->feedback = new PSCM_Feedback (FALSE, "ID must be a integer!");
        
        if( !is_float($_price) )
            $this->feedback = new PSCM_Feedback (FALSE, "Price must be a floating point in 'xx.xx' format!");
        
        if( !is_int($_pp) )
            $this->feedback = new PSCM_Feedback (FALSE, "Premium points must be a integer!");
        
        if( strlen($_desc) > 25 )
            $this->feedback = new PSCM_Feedback (FALSE, "Description is too long (max. 25 chars)!");
        
        if( !($this->feedback instanceof PSCM_Feedback) )
        {
            $this->id = $_id;
            $this->price = round($_price, 2);
            $this->premium_points = $_pp;
            $this->description = $_desc;
            $this->feedback = new PSCM_Feedback (TRUE, "All is good! :)");
        }
    }
    
    public function ID() { return $this->offer_name; }    
    public function Price() { return $this->price; } 
    public function PremiumPoints() { return $this->premium_points; } 
    public function Description() { return $this->description; } 
}
