<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Disbursement extends MX_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $this->load->view('account/viewdisbursement');
    }

    public function monthlydisburse()
    {
        $this->load->view('account/monthlydisburse');
    }

}

?>