<?php 
		
	
// $url = 'https://www.absolutefinserve.com/back-office/checkrisk.php?Mobile=8808106268';
// 		$ch=curl_init();
// 		curl_setopt($ch, CURLOPT_URL, $url);
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// 		$output=curl_exec($ch);
// 		curl_close($ch);
// 		$data = json_decode($output);
// 		print_r($data->ID);
?>


https://github.com/angelleye/paypal-php-library

file:///home/aneet/Downloads/User_guide_paypal_payment_integration_codeigniter.pdf

https://github.com/nrshoukhin/codeigniter-paypal-library/tree/master/application/third_party/PayPal-PHP-SDK


https://developer.paypal.com/developer/applications/edit/SB:QWU4QklJM2tQdEVRTGJCVVJCVXVsd1lrTGlCTXVockxXekZJZURLVE01bEpoeEtwNXRqUE9GN202cG5KTXVEbFBCaGxIYzNpN2puYk5JdGE=?appname=Default%20Application

https://github.com/angelleye/paypal-php-library/blob/release/samples/rest/checkout_orders/CreateCaptureOrder.php

<?php 
function gmdate_to_mydate($gmdate,$localtimzone){
	/* $gmdate must be in YYYY-mm-dd H:i:s format*/
	date_default_timezone_set($localtimzone);
	$timezone=date_default_timezone_get();
	$userTimezone = new DateTimeZone($timezone);
	$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($gmdate, $gmtTimezone);
	$offset = $userTimezone->getOffset($myDateTime);
	return date("Y-m-d H:i:s", strtotime($gmdate)+$offset);
}
date_default_timezone_set("UTC");
$utc_date=date("Y-m-d H:i:s");
echo "UTC DATE TIME - ".$utc_date."<br>";

$localtimzone='Asia/Kolkata';
$local_date=gmdate_to_mydate($utc_date,$localtimzone);
echo "India LOCAL DATE TIME - ".$local_date."<br>";

$localtimzone='Australia/Melbourne';
$local_date=gmdate_to_mydate($utc_date,$localtimzone);
echo "Australia LOCAL DATE TIME - ".$local_date."<br>";

function select_Timezone($selected = '') {
    $OptionsArray = timezone_identifiers_list();
        $select= '<select name="SelectContacts">';
        while (list ($key, $row) = each ($OptionsArray) ){
            $select .='<option value="'.$key.'"';
            $select .= ($key == $selected ? ' selected' : '');
            $select .= '>'.$row.'</option>';
        }  // endwhile;
        $select.='</select>';
return $select;
}

echo select_Timezone();
?>
