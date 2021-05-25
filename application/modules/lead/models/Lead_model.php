<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lead_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //===business suggessions for adding contact person=========//
    public function contact_business_suggession($term,$bid=''){

        $urole_id = $this->userdata['urole_id'];
        $user_id = $this->userdata['user_id'];
        $dept_id = $this->userdata['dept_id'];
       
        if($dept_id==1 ||$dept_id==2||$dept_id==10){

            $where = "business.`business_name` like '$term%' AND `business`.`status` = '1' 
            AND `user`.`status` ='1' 
            AND (`business`.`business_createdby`=".$user_id." OR (`user`.`createdby`=".$user_id." AND `user`.urole_id=".$urole_id."))";
           
            return $this->db->query("SELECT `business`.business_id,`business`.business_name 
            FROM `business`
            JOIN  `user` ON `user`.`user_id` = `business`.`business_createdby`
            WHERE $where 
            ORDER BY `business`.`business_name` ASC")->result_array();

        }else{

            $where = "`business_name` like '$term%' AND `business`.`status` = '1' AND (business_createdby=".$user_id."  OR `business`.`assign_to`=".$user_id.")";
            if(!empty($bid)){ $where .=" AND business_id NOT IN(".$bid.")"; }
            $this->db->select('business_id,business_name');
            $this->db->from('business');
            $this->db->where($where);
            $query = $this->db->get();
            return $query->result_array();        
        }
        
    }

    //=========contacts of business======//
    public function contacts_of_business($bid){
        return $this->db->select('contact_id,contact_person')->from('contact')
        ->where("`business_id`='".$bid."'")
        ->order_by('contact_person','ASC')
        ->get()->result_array();
    }

    public function deal_business_suggession($term){

/*        $where = "business.`business_name` like '$term%' AND `business`.`status` = '1' ";
       
        return $this->db->query("SELECT `business`.business_id,`business`.business_name 
        FROM `business`
        LEFT JOIN  `deal` ON `deal`.`business_id` = `business`.`business_id` AND `deal`.`status` !='2'
        WHERE $where 
        AND `deal`.`business_id` IS NULL
        ORDER BY `business`.`business_name` ASC")->result_array();*/



        $urole_id = $this->userdata['urole_id'];
        $user_id = $this->userdata['user_id'];
        $dept_id = $this->userdata['dept_id'];
       
        if($dept_id==1 ||$dept_id==2||$dept_id==10){

            $where = "`deal`.`business_id` IS NULL AND business.`business_name` like '$term%' AND `business`.`status` = '1' 
            AND `user`.`status` ='1' 
            AND (`business`.`business_createdby`=".$user_id." OR (`user`.`createdby`=".$user_id." AND `user`.urole_id=".$urole_id."))";
           
            return $this->db->query("SELECT `business`.business_id,`business`.business_name 
            FROM `business`
            LEFT JOIN  `deal` ON `deal`.`business_id` = `business`.`business_id` AND `deal`.`status` !='2'
            JOIN  `user` ON `user`.`user_id` = `business`.`business_createdby`
            WHERE $where 
            ORDER BY `business`.`business_name` ASC")->result_array();

        }else{
            $where = "`deal`.`business_id` IS NULL AND `business_name` like '$term%' AND `business`.`status` = '1' AND business_createdby=".$user_id;
            return $this->db->query("SELECT `business`.business_id,`business`.business_name FROM `business`
            LEFT JOIN  `deal` ON `deal`.`business_id` = `business`.`business_id` AND `deal`.`status` !='2'
            WHERE $where 
            ORDER BY `business`.`business_name` ASC")->result_array();
                 
        }
        
    

    }

    public function cp_suggession($term,$busines=""){

        if($this->userdata['dept_id']==1||$this->userdata['dept_id']==2||$this->userdata['dept_id']==10){
            $where = "`contact_person` like '%$term%' AND `contact`.`status`='1' AND `business.status`='1'";
            $where .= " AND (`user`.`createdby` =".$this->userdata['user_id']." OR `contact`.`contact_createdby`=".$this->userdata['user_id'].")";
            $this->db->select('contact_id,contact_person,contact_email,contact_phone,business.business_id,business_name');
            $this->db->from('contact'); 
            $this->db->join('user','user.user_id = contact.contact_createdby');       
            $this->db->join('business','contact.business_id = business.business_id');       
            $this->db->where($where);
            $query = $this->db->get();
            $result = $query->result_array();    
        }else{
            $where = "`contact_person` like '%$term%' AND `contact`.`status`='1' AND `business.status`='1'";
            $where .= " AND `contact`.`contact_createdby` =".$this->userdata['user_id'];
            $this->db->select('contact_id,contact_person,contact_email,contact_phone,business.business_id,business_name');
            $this->db->from('contact'); 
            $this->db->join('business','contact.business_id = business.business_id');       
            $this->db->where($where);
            $query = $this->db->get();
            $result = $query->result_array();   
        }

        return $result;
    }

    public function check_contact_exist($email,$business_id,$contactid=''){

        $dept_id = $this->userdata['dept_id'];
        $user_id = $this->userdata['user_id'];
        $urole_id = $this->userdata['urole_id'];
        $createdby = $this->userdata['createdby'];

        if($dept_id==1 || $dept_id==2){

            $where = "`contact_email`='".$email."' AND `contact`.`status` !='2' AND `business`.`status` !='2'
            AND `business`.`business_id`= '".$business_id."'" ;
            if(!empty($contactid)){
                $where .= " AND `contact_id` !='".$contactid."'";
            }

            return $this->db->query("SELECT contact_email 
            FROM `contact`
            JOIN  `business` ON `contact`.`business_id` = `business`.`business_id`
            WHERE $where")
            ->row_array();

        }else{

            // $where = "`contact_email`='".$email."' AND `contact`.`status` !='2' AND `business`.`status` !='2'
            // AND `business`.`business_id`= '".$business_id."' AND `business`.`business_createdby`=".$user_id ;

            $where = "`contact_email`='".$email."' AND `contact`.`status` !='2' AND `business`.`status` !='2'
            AND `business`.`business_id`= '".$business_id."'";

            
            if(!empty($contactid)){
                $where .= " AND `contact_id` !='".$contactid."'";
            }

            return $this->db->query("SELECT contact_email 
            FROM `contact`
            LEFT JOIN  `business` ON `contact`.`business_id` = `business`.`business_id`
            WHERE $where")
            ->row_array();
        }
    }

    public function check_business_exist($bus_name,$bid=""){

        $dept_id = $this->userdata['dept_id'];
        $user_id = $this->userdata['user_id'];
        $urole_id = $this->userdata['urole_id'];
        $createdby = $this->userdata['createdby'];

        if($dept_id==1 || $dept_id==2){

            $where = "business.`business_name`='".$bus_name."' AND `business`.`status` ='1' 
            AND `user`.`status` ='1' 
            AND (`business`.`business_createdby`=".$user_id." OR (`user`.`createdby`=".$user_id." AND `user`.urole_id=".$urole_id."))";

            if(!empty($bid)){ $where .=" AND business.business_id !=$bid"; }           

            return $this->db->query("SELECT `business`.business_name,`business`.`business_id`,`business`.business_createdby,`business`.assign_to
            FROM `business`
            JOIN  `user` ON `user`.`user_id` = `business`.`business_createdby`
            WHERE $where 
            ORDER BY `business`.`business_name` ASC")->row_array();

        }else{

            $where = "business.`business_name`='".$bus_name."' AND `business`.`status` = '1' 
            AND `user`.`status` ='1' 
            AND (`business`.`business_createdby`=".$user_id." OR ((`user`.`createdby`=".$createdby." OR `user`.`user_id`=".$createdby.") AND `user`.urole_id=".$urole_id."))";

            if(!empty($bid)){ $where .=" AND business.business_id !=$bid"; }           
            return $this->db->query("SELECT `business`.business_name,`business`.`business_id`,`business`.business_createdby,`business`.assign_to 
            FROM `business`
            JOIN  `user` ON `user`.`user_id` = `business`.`business_createdby`
            WHERE $where 
            ORDER BY `business`.`business_name` ASC")->row_array();
        }
    }

    //==========no more use===========//
    public function contact_deals_of_business($bid,$status=''){

        $where = "contact.business_id = $bid";
        $joinON = '';
        if($status=='current'){
            $joinON = " AND deal.user_id=0";
        }

        $query = "SELECT *, contact.contact_id AS cid,pipelinstage.pstage_name 
        FROM `contact` 
        LEFT JOIN deal ON deal.contact_id = contact.contact_id $joinON
        LEFT JOIN pipelinstage ON pipelinstage.pstage_id = deal.pstage_id
        WHERE $where";
        return $this->db->query($query)->result_array();
    }
    //==========no more use===========//

    public function get_my_stages(){
        $where = ($this->userdata['dept_id']==1||$this->userdata['dept_id']==2)?"`pipelinstage`.user_id=".$this->userdata['user_id']:"`pipelinstage`.user_id=".$this->userdata['createdby'];
        $query = "SELECT pstage_name,pstage_id,last_stage 
        FROM `pipelinstage` 
        WHERE $where";
        return $this->db->query($query)->result_array();
    }

    public function add_contact($bData,$userData){
        $this->db->trans_start();
        if(!empty($bData)){
            $userData['business_id'] = $this->generalmodel->add('business',$bData);
        }
        $lastid = $this->generalmodel->add('contact',$userData);
        $this->db->trans_complete();
        return $lastid;        
    }

    public function deal_detail($id){
        return $this->db->query("Select deal.*,business.*,contact.* FROM deal
        JOIN  business ON deal.business_id=business.business_id AND business.status !='2'
        JOIN contact ON contact.contact_id=deal.contact_id AND contact.business_id = deal.business_id AND contact.status !='2'
        WHERE deal.status !='2' AND deal.deal_id=$id")->row_array();
    }
}
?>