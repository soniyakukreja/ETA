<?php 
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Compliance_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}


    public function bus_suggession($term){

        $where = "business.`business_name` like '$term%' AND `business`.`status` = '1' ";
        $this->db->select('GROUP_CONCAT(business.business_id SEPARATOR ",") AS ids');
        $this->db->from('business');        
        $this->db->where($where);
        $query = $this->db->get();
        $res = $query->row_array();
        if(!empty($res['ids'])){
            $ids= $res['ids'];
            $where .= " AND business_id IN($ids)";
        }
        $this->db->select('business_id,business_name,business_createdby');
        $this->db->from('business');
        $this->db->where($where);
        $query = $this->db->get();

        return $query->result_array();           
    }

}