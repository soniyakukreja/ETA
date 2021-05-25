<?php 
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Supplier_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function add_supplier($udata,$data){
		$this->db->trans_start();
		$this->db->insert('user', $udata);
		$data['user_id'] = $this->db->insert_id();

		$this->db->insert('supplier', $data);
		$lastid = $this->db->insert_id();
		$this->db->trans_complete();
		return $lastid;
	}

}

?>