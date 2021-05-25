<?php 
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Indus_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

    public function ia_bus_suggession($term,$id=""){

        
        if(!empty($id)){
            $where1 = " AND IF(`indassociation`.`status` !='', `indassociation`.`status`='1' AND `indassociation`.`ia_id` !=".$id." ,(1=1))";
        }else{
            $where1 = " AND IF(`indassociation`.`status` !='', `indassociation`.`status`='1',(1=1))";
        }

        $where = "business.`business_name` like '$term%' AND `business`.`status` = '1' ";
        
        $this->db->select('GROUP_CONCAT(business.business_id SEPARATOR ",") AS ids');
        $this->db->from('business'); 
        $this->db->join('indassociation','indassociation.business_id = business.business_id');       
        $this->db->where($where.$where1);
        $query = $this->db->get();
        $res = $query->row_array();

        if(!empty($res['ids'])){
            $ids= $res['ids'];
            $where .= " AND business_id NOT IN($ids)";
        }


        $this->db->select('business_id,business_name');
        $this->db->from('business');
        $this->db->where($where);
        $query = $this->db->get();

        return $query->result_array();           
    
    }


	public function add_ia($udata,$data,$busData,$dealid=''){
		$this->db->trans_start();
		$this->db->insert('user', $udata);
		$data['user_id'] = $this->db->insert_id();

        if(!empty($busData)){
            $this->db->insert('business', $busData);
            $data['business_id'] = $this->db->insert_id();   
        }

		$this->db->insert('indassociation', $data);
        $lastid = $this->db->insert_id();


        if(!empty($dealid)){
            $this->db->update('deal',array('user_id'=>$data['user_id'],'user_role'=>'3'),array('deal_id'=>$dealid));
        }
        $f= 0;
        for($i=1; $i <=5 ; $i++) { 
            $pipeData[$f]['user_id'] = $data['user_id'];
            $pipeData[$f]['roles_id'] = 2;
            $pipeData[$f]['pstage_status'] = "1";           
            $pipeData[$f]['pstage_name'] = "Stage ".$i;
            $pipeData[$f]['last_stage'] = ($i<5)?0:1;
            $f++;
        }
        $this->db->insert_batch("pipelinstage",$pipeData);

		$this->db->trans_complete();
		return $lastid;
	}

    public function update_ia($userData,$licData,$busData,$user_id,$business_id){
        $this->db->trans_start();
        
        if($busData['update_business']){
            unset($busData['update_business']);
            $this->generalmodel->updaterecord('business',$busData,'business_id='.$business_id);
        }else{
            unset($busData['update_business']);
            $this->db->insert('business', $busData);
            $licData['business_id'] = $this->db->insert_id();   
        }
        
        $this->generalmodel->updaterecord('user',$userData,'user_id='.$user_id);
        $query = $this->generalmodel->updaterecord('indassociation',$licData,'user_id='.$user_id);

        $this->db->trans_complete();
        return $query;
    }
}

?>