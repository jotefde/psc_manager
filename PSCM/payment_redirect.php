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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function pscm_valid_form()
{
    if( !isset($_POST["pscm_merchant"]) )
        return false;
    if( !isset($_POST["pscm_offer"]) )
        return false;
    
    $merchant = test_input($_POST["pscm_merchant"]);
    $offername = test_input($_POST["pscm_offer"]);
    
    $stmt = PSCM_DB::prepare("SELECT count(*) FROM accounts WHERE name=:vname LIMIT 1");
           $stmt->bindParam(":vname", $merchant, PDO::PARAM_STR);
    $stmt->execute();

    if( $stmt->fetchColumn() < 1 )
        return false;
    $stmt->closeCursor();

    $offer = PSCManager::getByName($offername);
    if( !$offer )
        return false;
    
    return array($offer, $merchant);
}

$valid = pscm_valid_form();
if( $valid == false )
    return false;

list($offer, $acc_name) = $valid;

$key = PSCManager::prop('api_private_key');
$data = array(
	'uid' => PSCManager::prop('api_user_id'),
	'public_key' => PSCManager::prop('api_public_key'),
	'amount' => round( $offer->Price()*100, 0 ),
	'label' => $offer->Description(),
	'control' => PSCManager::prop('api_control').'?action=hmm',
	'success_url' => PSCManager::prop('api_termination_url'),
	'failure_url' => PSCManager::prop('api_termination_url'),
	'notify_url' => urlencode(''),
);
$data['crc'] = md5(join('', $data) . $key);

echo '<form method="post" name="paysafecard" action="'. PSCManager::prop('api_url') .'">';
foreach($data as $field => $value)
	echo '<input type="hidden" name="' . $field . '" value="' . $value . '">';

echo '</form>
<p>Za chwile zostaniesz przekierowany do strony wplaty.</p>
<p>Jezli przekierowanie nie nastapi w ciagu kilku sekund, kliknij <a href="#" onclick="document.paysafecard.submit(); return false;">tutaj</a>.</p>
<script>setTimeout(function() { document.paysafecard.submit(); }, 10);</script>';