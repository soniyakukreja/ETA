<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testmail extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('generalmodel');
	}
	
	public function sendtestmail(){

		$to ="soniyakukreja091@gmail.com";
		$subject = "Test Subject ";
		$message="Test mail on 45";
		$mailresponce = $this->sendGridMail('',$to,$subject,$message);

		print_r($mailresponce); exit;
	}
}