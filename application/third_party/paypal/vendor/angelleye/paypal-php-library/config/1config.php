<?php
/**
 * Timezone Setting
 * List of Supported Timezones: http://www.php.net/manual/en/timezones.php
 */
date_default_timezone_set('Australia/Melbourn');

/**
  * Enable Sessions
  * Checks to see if a session_id exists.  If not, a new session is started.
  */
if(!session_id()) session_start();

/** 
 * Sandbox Mode - TRUE/FALSE
 * If you are running tests in the PayPal Sandbox, $sandbox should be TRUE.
 * If you are running live / production calls, $sandbox should be FALSE.
 *
 * Debug Mode - TRUE/FALSE
 * If you would like to output PHP errors, set this to TRUE.
 */
$sandbox = TRUE;
$debug = TRUE;
$domain = $sandbox ? 'http://45.33.105.92/ETA/' : 'http://45.33.105.92/ETA/';

/**
 * Enable error reporting if running in sandbox mode.
 */
if($debug)
{
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', '1');	
}

/**
 * PayPal API Version
 * ------------------
 * The library is currently using PayPal API version 109.0.  
 * You may adjust this value here and then pass it into the PayPal object when you create it within your scripts to override if necessary.
 */
$api_version = '204.0';

/**
 * PayPal Application ID
 * --------------------------------------
 * The application is only required with Adaptive Payments applications.
 * You obtain your application ID but submitting it for approval within your 
 * developer account at http://developer.paypal.com
 *
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * The sandbox value included here is a global value provided for developrs to use in the PayPal sandbox.
 */
$application_id = $sandbox ? 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta' : '';

/**
 * PayPal Developer Account Email Address
 * This is the email address that you use to sign in to http://developer.paypal.com
 */
$developer_account_email = 'lawrence@ethicaltradealliance.com';

/**
 * PayPal Gateway API Credentials
 * ------------------------------
 * These are your PayPal API credentials for working with the PayPal gateway directly.
 * These are used any time you're using the parent PayPal class within the library.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may obtain these credentials by logging into the following with your PayPal account: https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-api-run
 */
$api_username = $sandbox ? 'sb-qcxqs3115305_api1.business.example.com' : 'LIVE_API_USERNAME';
$api_password = $sandbox ? 'WBJGDVFYZD5ESCKE' : 'LIVE_API_PASSWORD';
$api_signature = $sandbox ? 'AHm9n15hzWP5MCR3-.VL0w-j9aDVAu9V17JKZ8RQtV3ddno8mam-1.cB' : 'LIVE_API_SIGNATURE';

/**
 * Payflow Gateway API Credentials
 * ------------------------------
 * These are the credentials you use for your PayPal Manager:  http://manager.paypal.com
 * These are used when you're working with the PayFlow child class.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may use the same credentials you use to login to your PayPal Manager, 
 * or you may create API specific credentials from within your PayPal Manager account.
 */
$payflow_username = $sandbox ? 'SANDBOX_PAYFLOW_USERNAME' : 'LIVE_PAYFLOW_USERNAME';
$payflow_password = $sandbox ? 'SANDBOX_PAYFLOW_PASSWORD' : 'LIVE_PAYFLOW_PASSWORD';
$payflow_vendor = $sandbox ? 'SANDBOX_PAYFLOW_VENDOR' : 'LIVE_PAYFLOW_VENDOR';
$payflow_partner = $sandbox ? 'SANDBOX_PAYFLOW_PARTNER' : 'LIVE_PAYFLOW_PARTNER';

/**
 * PayPal REST API Credentials
 * ---------------------------
 * These are the API credentials used for the PayPal REST API.
 * These are used any time you're working with the REST API child class.
 * 
 * You may obtain these credentials from within your account at http://developer.paypal.com
 */
$rest_client_id = $sandbox ? 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta' : 'LIVE_CLIENT_ID';
$rest_client_secret = $sandbox ? 'ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D' : 'LIVE_SECRET_ID';

/**
 * PayPal Finance Portal API
 * -------------------------
 * These are credentials used for obtaining a PublisherID used in Bill Me Later Banner code.
 * As of now, these are specialized API's and you must obtain credentials directly from a PayPal rep.
 */
$finance_access_key = $sandbox ? 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta' : 'LIVE_ACCESS_KEY';
$finance_client_secret = $sandbox ? 'ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D' : 'LIVE_CLIENT_SECRET';

/**
 * Third Party User Values
 * These can be setup here or within each caller directly when setting up the PayPal object.
 */
$api_subject = '';	// If making calls on behalf a third party, their PayPal email address or account ID goes here.
$device_id = '';
$device_ip_address = $_SERVER['REMOTE_ADDR'];

/**
 * Enable Headers
 * Option to print headers to screen when dumping results or not.
 */
$print_headers = false;

/**
 * Enable Logging
 * Option to log API requests and responses to log file.
 */
$log_results = false;
$log_path = $_SERVER['DOCUMENT_ROOT'].'ETA/logs/';
$log_level = 'DEBUG';        // Sandbox Mode : DEBUG, INFO, WARNING, ERROR. ||  Live Mode : INFO, WARNING, ERROR
