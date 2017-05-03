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

$SETTINGS = array();

$SETTINGS["api_url"] = 'https://homepay.pl/paysafecard/';
$SETTINGS["api_control"] = PSCM_URL.'api.php';
$SETTINGS["api_public_key"] = 'YOUR_PUBLIC_KEY';
$SETTINGS["api_private_key"] = 'YOUR_PRIVATE_KEY';
$SETTINGS["api_user_id"] = 'YOUR_USER_ID';
$SETTINGS["api_termination_url"] = urlencode(PSCM_ADDR);
$SETTINGS["api_currency"] = 'PLN'; // Only information for users
$SETTINGS["api_cryptor_key"] = 'YOUR_UNIQUE_KEY'; // IMPORTANT to set your own unique key like 'fdhjshbfu782r7y2'
     
/*
 * Set connection to database
 * If instance of PDO connection is exists:
 *  $pscm_sql["pdo"] = $INSTANCE_OF_PDO
 * Else set this value to null
 */

$pscm_sql["pdo"] = null; // If is null then create the new pdo connection
$pscm_sql["host"] = 'localhost';
$pscm_sql["user"] = 'root';
$pscm_sql["password"] = 'skubi23';
$pscm_sql["dbname"] = 'dbhonor';

