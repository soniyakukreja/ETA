<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Kam_dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index(){

		$data['meta_title'] = 'dashboard';
		$this->load->view('kam_dashboard',$data);
	}
}