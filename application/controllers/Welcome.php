<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		//echo encrypt_pass('123456'); exit;
		$this->load->view('test');
	}
	public function testmobile(){
		$this->load->library('brickcustom');
		//$this->brickcustom->ff();

		$mobile = '+917470560225';
		$rg = 'IN';
		$cc = '91';
		$return  = $this->brickcustom->validateMobile($mobile,$rg,$cc);
		echo $return; exit;

	}
	public function testview(){
		$this->load->view('include/header');
		$this->load->view('test');
		$this->load->view('include/footer');
	}
}
