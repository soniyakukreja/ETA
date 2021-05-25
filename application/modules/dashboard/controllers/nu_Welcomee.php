<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once APPPATH.'third_party/phonenumber-master/tests/PhoneNumberTest.php';
// require_once APPPATH.'third_party/phonenumber-master/tests/ConstantTest.php';


require_once APPPATH.'third_party/phonenumber-master/src/PhoneNumber.php';
require_once APPPATH.'third_party/phonenumber-master/src/PhoneNumberException.php';

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;

class Welcomee extends CI_Controller {


	
	public function index()
	{
		//echo encrypt_pass($password); exit;
		//echo CI_VERSION; =>3.1.1
		//echo phpinfo();=>7.3.12
		//$this->load->view('phone_validation');



		try {
		    $number = PhoneNumber::parse('+333');
		}
		catch (PhoneNumberParseException $e) {
		    echo  'The string supplied is too short to be a phone number.';
		}



		if (! $number->isPossibleNumber('7470560225')) {
		   echo  'no its not possible';
		}

		if (! $number->isValidNumber('7470560225')) {
		    // strict check relying on up-to-date metadata library
		    echo  'no its not valid';
		}else{
			echo 'valid=> '.$no;
		}

	}

	public function test(){
		$this->load->view('test');
	}
}

