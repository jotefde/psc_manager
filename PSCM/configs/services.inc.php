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

$SERVICES = array();

$SERVICES[] = array(
    "price" => 5.00,
    "premium_points" => 10,
    "description" => "10 Premium Points"
);

$SERVICES[] = array(
    "price" => 20.00,
    "premium_points" => 50,
    "description" => "50 Premium Points"
);