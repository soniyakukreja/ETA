<?php
// Include required library files.
require_once('../../../../../autoload.php');
//require_once('../../../includes/config.php');



        $domain = 'http://45.33.105.92/ETA/';
        $rest_client_id = 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta';
        $rest_client_secret = "ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D";
        $configArray = array(
            'Sandbox' => TRUE,
            'ClientID' => $rest_client_id,
            'ClientSecret' => $rest_client_secret,
            'LogResults' => false,
            'LogPath' =>  $_SERVER['DOCUMENT_ROOT'].'/ETA/logs/',
            'LogLevel' => 'DEBUG'
        );


// $configArray = array(
//     'Sandbox' => $sandbox,
//     'ClientID' => $rest_client_id,
//     'ClientSecret' => $rest_client_secret,
//     'LogResults' => $log_results,
//     'LogPath' => $log_path,
//     'LogLevel' => $log_level
// );

$PayPal = new angelleye\PayPal\rest\payments\PaymentAPI($configArray);
$order_id = '8N641068558163730'; // Add sale transaction id to see the details of that Order

$result = $PayPal->OrderGet($order_id);
echo "<pre>";
print_r($result);

