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

if( isset($_GET["termination"]) )
{
    printf('<link href="%s" rel="stylesheet">', PSCM_PUBLIC.'/css/style.css');
    $action = $_GET["termination"];
    if( $action == "success" ):
    ?>
    
    <?php
    elseif( $action == "failure" ):
        
    endif;
}