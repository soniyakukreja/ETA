<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->session->userdata('userdata');
	}


	public function index()
	{
		$data['meta_title'] = 'Dashboard';
		$this->load->view('account',$data);
	}
}