<?php 
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Licensee_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}


    public function lcnsee_bus_suggession($term){

        $where = "business.`business_name` like '$term%' AND `business`.`status` = '1' ";

        return $this->db->query("SELECT `business`.business_id,`business`.business_name 
        FROM `business`
        LEFT JOIN  `licensee` ON `licensee`.`business_id` = `business`.`business_id` AND `licensee`.`status`!='2'
        LEFT JOIN  `deal` ON `deal`.`business_id` = `business`.`business_id` AND `deal`.`status` !='2'
        WHERE $where 
        AND `licensee`.`business_id` IS NULL  AND `deal`.`business_id` IS NULL
        ORDER BY `business`.`business_name` ASC")->result_array();
    }

	public function add_licensee($udata,$data,$busData,$dealid=''){
		$this->db->trans_start();
		$this->db->insert('user', $udata);
		$data['user_id'] = $this->db->insert_id();

        if(!empty($busData)){
            $this->db->insert('business', $busData);
            $data['business_id'] = $this->db->insert_id();   
        }

		$this->db->insert('licensee', $data);
		$lastid = $this->db->insert_id();

        if(!empty($dealid)){
            $this->db->update('deal',array('user_id'=>$data['user_id'],'user_role'=>'2'),array('deal_id'=>$dealid));
        }
        $f= 0;
        for($i=1; $i <=5 ; $i++) { 
            $pipeData[$f]['user_id'] = $data['user_id'];
            $pipeData[$f]['roles_id'] = 2;
            $pipeData[$f]['pstage_name'] = "Stage ".$i;
            $pipeData[$f]['pstage_status'] = "1";
            $pipeData[$f]['last_stage'] = ($i<5)?0:1;
            $f++;
        }
        $this->db->insert_batch("pipelinstage",$pipeData);
		$this->db->trans_complete();
		return $lastid;
	}

    public function update_li($userData,$licData,$busData,$user_id,$business_id){
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
        $query = $this->generalmodel->updaterecord('licensee',$licData,'user_id='.$user_id);
        $this->db->trans_complete();
        return $query;
    }

    public function getLicenseeData($id){
        
        return $this->db->select('lic_id,licensee.user_id,category,lic_number,lic_profilepicture,lic_startdate,lic_enddate,licensee.country AS l_country,
            licensee.business_id,licensee.business_name,licensee.business_id,firstname,lastname,profilepicture,email,contactno,business_street1,business_suburb,business_state,
            business_country,business_postalcode,user.assign_to,timezone')->from('licensee')
        ->join('user','user.user_id= licensee.user_id')
        ->join('business','business.business_id = licensee.business_id')
        ->where("licensee.user_id = $id")
        ->get()->row_array();
    }

    public function delete_lic($id){
        
        $this->db->trans_start();

        $b_query = $this->db->select('business_id')
        ->from('licensee')->where("user_id =$id")->get()->row_array();

        if(!empty($b_query)){
            $where = "business_id =".$b_query['business_id'] ;
            $this->generalmodel->updaterecord('business',array('status'=>'2'),$where);
            $this->generalmodel->updaterecord('contact',array('status'=>'2'),$where);
        }

        $this->generalmodel->updaterecord('user',array('status'=>'0'),'user_id='.$id);
        $this->generalmodel->updaterecord('licensee',array('status'=>'2'),'user_id='.$id);

        $this->db->trans_complete();
    }

    public function check_lic_number($lic_no){
        return $this->db->select('lic_number')->from('licensee')->where("`lic_number` ='$lic_no'")->get()->row_array();
    }
}

?>