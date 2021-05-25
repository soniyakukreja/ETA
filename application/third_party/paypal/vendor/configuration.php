<?php
/**
 * Timezone Setting
 * List of Supported Timezones: http://www.php.net/manual/en/timezones.php
 */
//date_default_timezone_set('Australia/Melbourn');

/**
  * Enable Sessions
  * Checks to see if a session_id exists.  If not, a new session is started.
  */
//if(!session_id()) session_start();

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
 * Enable Logging
 * Option to log API requests and responses to log file.
 */
$log_results = false;
$log_path = $_SERVER['DOCUMENT_ROOT'].'ETA/logs/';
$log_level = 'DEBUG';        // Sandbox Mode : DEBUG, INFO, WARNING, ERROR. ||  Live Mode : INFO, WARNING, ERROR




