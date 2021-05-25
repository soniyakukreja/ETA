<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/phonenumber-master/src/PhoneNumber.php';
use Brick\PhoneNumber\PhoneNumber;

class Brickcustom {
    private $CI;
    function __construct()
    {
        ob_start();
        error_reporting(0);

        $this->CI = & get_instance();
    }

    public function validateMobile($mobile,$user_regioncode,$user_cc){
        $number = PhoneNumber::parse($mobile);
        $regionCode = $number->getRegionCode();
        $cc = $number->getCountryCode();

        if(!$number->isPossibleNumber()) {
            return false;
        }elseif(!$number->isValidNumber()) {
            return false;
        }elseif($regionCode !=$user_regioncode) {
            return false;
        }elseif($cc != $user_cc){
            return false;
        }
    }
}