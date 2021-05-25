<?php 

use \angelleye\PayPal\rest\checkout_orders\CheckoutOrdersAPI;

require_once APPPATH. 'third_party/paypal/vendor/autoload.php';


class Paypal_lib{

    function __construct()
    {
        $this->configArray = array(
            'Sandbox' => TRUE,
            'ClientID' => 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta',
            'ClientSecret' => "ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D",
            'LogResults' => false,
            'LogPath' =>  $_SERVER['DOCUMENT_ROOT'].'/ETA/logs/',
            'LogLevel' => 'DEBUG'
        );        
    }

	function create_capture_order($items,$orderAmt,$shipping,$payer,$discount=0){

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

        $PayPal = new CheckoutOrdersAPI($configArray);
        $intent = 'CAPTURE';            // Required
        $currency = 'USD';              // The three-character ISO-4217 currency code that identifies the currency. https://developer.paypal.com/docs/integration/direct/rest/currency-codes/

        $orderItems = $items;

        $amount = array(
            'currency_code' => $currency,
            'value' => ($orderAmt-$discount),
            'breakdown' => array(
                'item_total' => array(          // The subtotal for all items.
                    'value' => $orderAmt,
                    'currency_code' => $currency
                ),
                'shipping' => array(            // The shipping fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'handling' => array(            // The handling fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'tax_total' => array(            // The total tax for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'insurance' => array(            // The insurance fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'shipping_discount' => array(    // The shipping discount for all items.
                    'value' => $discount,
                    'currency_code' => $currency
                )
            )
        );

        $application_context = array(
            'brand_name' => 'Ethical Alliance Trade',              // The label that overrides the business name in the PayPal account on the PayPal site.
            'locale' => 'en-US',                          // PayPal supports a five-character code.
            'landing_page' => 'BILLING',                    // Allowed Values : LOGIN,BILLING
            //'shipping_preferences' => 'SET_PROVIDED_ADDRESS',    // Allowed Values : GET_FROM_FILE , NO_SHIPPING , SET_PROVIDED_ADDRESS
            'user_action' => 'CONTINUE',                  // Configures a Continue or Pay Now checkout flow.
            'payment_method' => array(
                'payer_selected' => 'PAYPAL',                   // Values : PAYPAL,PAYPAL_CREDIT. The customer and merchant payment preferences.
                'payee_preferred' => 'UNRESTRICTED'             // Values : UNRESTRICTED , IMMEDIATE_PAYMENT_REQUIRED
            ),
            'return_url' => $domain.'shop/success',  // The URL where the customer is redirected after the customer approves the payment.
            'cancel_url' => $domain.'shop/cancel', // The URL where the customer is redirected after the customer cancels the payment.
        );
    
        if(!empty($shipping)){
            $application_context['shipping_preferences'] = 'SET_PROVIDED_ADDRESS';
        }else{
            $application_context['shipping_preferences'] = 'GET_FROM_FILE';
        }


        $purchase_units  = array(
            'reference_id' => 'default',                  // The ID for the purchase unit. Required for multiple purchase_units or if an order must be updated by using PATCH. If you omit the reference_id for an order with one purchase unit, PayPal sets the reference_id to default.
            'description' => 'ETA Consumer Shopping',            // The purchase description. Maximum length: 127.
            'custom_id' => 'CUST-PayPalFashions',         // The API caller-provided external ID. Used to reconcile client transactions with PayPal transactions. Appears in transaction and settlement reports but is not visible to the payer.
            'soft_descriptor' => "PayPalFashions",        // The payment descriptor on the payer's credit card statement. Maximum length: 22.
            'invoice_id' => 'ETAINV-'.rand(0,1000),        // The API caller-provided external invoice number for this order. Appears in both the payer's transaction history and the emails that the payer receives. Maximum length: 127.
            'amount' => $amount,
            //'shipping' => $shipping,                        // Add $shipping if you have shipping_preferences as SET_PROVIDED_ADDRESS in application context.
            'items' => $orderItems
        );

        if(!empty($shipping)){
            $purchase_units['shipping'] = $shipping;
        }

        $requestArray = array(
            'intent'=>$intent,
            'application_context' => $application_context,
            'purchase_units' => $purchase_units,
            //'payer' => $payer
        );



        if(!empty($payer)){
            $requestArray['payer'] = $payer;
        }

        $response = $PayPal->CreateOrder($requestArray);
        return $response ;
	}

    public function order_detail($order_id){
        $PayPal = new CheckoutOrdersAPI($this->configArray);
        return $PayPal->GetOrderDetails($order_id);
    }
}
