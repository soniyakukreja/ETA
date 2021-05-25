<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Generalmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }

    public function customquery($query,$returnType=""){
        $query = $this->db->query($query);
        if(empty($returnType) || $returnType=="result_array"){
            $return =  $query->result_array();
        }elseif($returnType=="result"){
            $return =  $query->result();
        }elseif($returnType=="row_array"){
            $return =  $query->row_array();
        }elseif($returnType=="row"){
            $return =  $query->row();
        }       
        return $return;
    }
	
	public function countrylist(){
		return $this->db->select('*')->from('country')->order_by('country_name','ASC')->get()->result_array();
	}

	public function categorylist(){
        $urole_id = $this->userdata['urole_id'];
		$query = $this->db->select('user_cat_id as id, user_cat_name as name')
        ->from('user_category')
        ->where(array('user_cat_status'=>'1','roles_id'=>$urole_id))
        ->order_by('name','ASC')->get()->result_array();
        return $query;
	}


    public function categorylist_old(){
        return $this->db->select('*')->from('category')->order_by('name','ASC')->get()->result_array();
    }

	public function deptlist(){
		return $this->db->select('*')->from('department')->order_by('deptname','ASC')->get()->result_array();	
	}

	public function add($tableName, $data) {

	    $this->db->insert($tableName, $data);
	    return $this->db->insert_id();
	}

    public function check_user_exist($email,$id=''){
        $where = "`email`='$email'";
        if(!empty($id)){ $where .= " AND `user_id` !=$id"; }
        return $this->db->select('email')->from('user')->where($where)->get()->row_array();
    }

    public function kam_list(){
        return $this->db->select("user_id,CONCAT_WS(' ',`firstname`,`lastname`) AS username")->from('user')->where(array('status'=>1,'dept_id'=>5))->get()->result_array();
    }

    public function getparticularData($select="*",$table,$where="",$returnType="",$limit="",$start="",$orderby=""){

        $this->db->select($select);
        $this->db->from($table);
        if($where!=""){
        	$this->db->where($where);
        }

        if($limit!="" && $start!="")
        {
            $this->db->limit($limit,$start);
        }
        else if($limit!="")
        {
            $this->db->limit($limit);
        }

        if($orderby!="")
        {
            $this->db->order_by($orderby);
        }

        $query = $this->db->get();


        if(empty($returnType) || $returnType=="result_array"){
            $return =  $query->result_array();
        }elseif($returnType=="result"){
            $return =  $query->result();
        }elseif($returnType=="row_array"){
            $return =  $query->row_array();
        }elseif($returnType=="row"){
            $return =  $query->row();
        }       
        return $return;
    }


    public function getfrommultipletables($data="*",$maintable, $tables,$where="",$groupby="",$orderby="",$limit="",$start="",$returnType="",$having=""){
		$return = array();
		$this->db->select($data);
		$this->db->from($maintable);

		foreach($tables as $value){
			$table = $value['table'];
			$on = $value['on'];
			$this->db->join($table,$on,'LEFT');
		}
      
		if($where !=""){
			$this->db->where($where);
		}

		if($limit!="" && $start!="")
        {
            $this->db->limit($limit,$start);
        }
        else if($limit!="")
        {
            $this->db->limit($limit);
        }
      
        if($groupby!="")
        {
            $this->db->group_by($groupby); 
        }
        
        if($orderby!="")
        {
            $this->db->order_by($orderby); 
        }
        if(!empty($having)){
        	 $this->db->having($having); 
        }
        
      $query = $this->db->get();

      if($query->num_rows() > 0){

      	if(empty($returnType) || $returnType=="result_array"){
            $return =  $query->result_array();

        }elseif($returnType=="result"){
            $return =  $query->result();
        }elseif($returnType=="row_array"){
            $return =  $query->row_array();
        }elseif($returnType=="row"){
            $return =  $query->row();
        }       
      } 
      return $return; 
    }

    public function deleterecord($table,$where){
        return $this->db->delete($table,$where);
    }

    public function updaterecord($table,$data,$where){
    	return $this->db->update($table,$data,$where);
    }
    public function insert_batchdata($table,$data){
        $str = $this->db->insert_batch($table, $data);
        if(!empty($str)){
            return true;
        }else{
            return false;
        }
    }


    public function mail_template($select,$type){
        return $this->getparticulardata($select,'email_template',array('type'=>$type,'status'=>'1'),'row_array');
    }


	public function modify($tableName, $colName, $id, $data) {

	    $this->db->where($colName, $id);

	    $this->db->update($tableName, $data);
	    return $this->db->affected_rows();
	}


	public function modifyMulti($tableName, $data1, $data) {

	    $this->db->where($data1);

	    $this->db->update($tableName, $data);
		return $this->db->affected_rows();
	}


	public function delete($tableName, $colName, $id) {

	    $this->db->where($colName, $id);

	    $this->db->delete($tableName);

	    return TRUE;
	}

	public function deleteMulti($tableName, $wh) {

	    $this->db->where($wh);

	    $this->db->delete($tableName);

	    return TRUE;
	}



    // To get single row of table by a id 

public function getSingleRowById($tableName, $colName, $id, $returnType = '') {

    $this->db->where($colName, $id);

    $result = $this->db->get($tableName);

    if ($result->num_rows() > 0) {

        if ($returnType == 'array')

            return $result->row_array();

        else

            return $result->row();
    }

    else

        return FALSE;

}



    // To get all row of matching criteria

public function getRowAllById($tableName, $colName, $id, $orderby = '', $orderformat = 'asc') {

    if ($colName != '' && $id != '')

        $this->db->where($colName, $id);

    if ($orderby != '')

        $this->db->order_by($orderby, $orderformat);

    $result = $this->db->get($tableName);

    if ($result->num_rows() > 0)

        return $result->result();

    else

        return FALSE;

}



    // To get data by multiple where 	

public function getRowByWhere($tableName, $filters = '', $select = '', $noRowReturn = '', $returnType = '', $orderby = '', $orderformat = 'asc') {

    if ($select != '')

        $this->db->select($select);

    if (count($filters) > 0) {

        foreach ($filters as $field => $value)

            $this->db->where($field, $value);

    }
    if ($orderby != '')

        $this->db->order_by($orderby, $orderformat);

    $result = $this->db->get($tableName);

    if ($result->num_rows() > 0) {

        if ($noRowReturn == 'single') {

            if ($returnType == 'array')

                return $result->row_array();

            else

                return $result->row();
        }

        else {
            if ($returnType == 'array')
                return $result->result_array();
            else
                return $result->result();
        }

    }
    else
        return FALSE;

}
 
    // Pagination function 

public function getPaginationData($tableName, $filters = '', $perPage, $start, $orderby, $orderformat,$selectData='') {
 
        //Set default order
	if($selectData!='') 
	{
		$this->db->select($selectData);
	}
    if ($orderformat == '')

        $orderformat = 'asc';

        //add where clause

    if ($filters != '' && count($filters) > 0)

        $this->db->where($filters);

    $this->db->limit($perPage, $start);

    $this->db->order_by($orderby, $orderformat);

    $result = $this->db->get($tableName);

    if ($result->num_rows() > 0)

        return $result->result();

    else

        return FALSE;

	}

/*---get--pagination---*/

public function get_pagination_result($table_name='',$id_array='',$limit='',$offset='',$orderid,$order=''){     
       
	     if(!empty($id_array)):
		 
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
             
            }
	      endif;
	    
        if($order!=''){
			 $this->db->order_by($orderid,$order); 
		}
         else{
			  $this->db->order_by('id','desc'); 
		 } 
		 
        if($limit > 0 && $offset>=0){ 
		
		    //$this->db->where($filters);
            $this->db->limit($limit, $offset);
			
            $query=$this->db->get($table_name);
			
            if($query->num_rows()>0)
                return $query->result();
            else
                return FALSE;
			
        }else{
            $query=$this->db->get($table_name);
            return $query->num_rows();
        }
    }


    //Function to return total number of rows

public function getTotalRows($tableName, $filters = NULL) {

    if ($filters != NULL) {

        $this->db->where($filters);

        $count = $this->db->count_all_results($tableName);

    }

    else

        $count = $this->db->count_all($tableName);

    return $count;

}
 
public function get_result($table_name='', $id_array='',$id_array2=''){
        
        if(!empty($id_array)):      
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
             
            }
       endif;
        if(!empty($id_array2)):     
            foreach ($id_array2 as $key => $value){
                $this->db->or_where($key, $value);
            }
        endif;
        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
}
 
public function get_row($table_name='', $id_array='', $id_array2=''){
	if(!empty($id_array)):      
		foreach ($id_array as $key => $value){
			$this->db->where($key, $value);
		}
	endif;
	if(!empty($id_array2)):     
		foreach ($id_array2 as $key => $value){
			$this->db->or_where($key, $value);
		}
	endif;
	$query=$this->db->get($table_name);
	if($query->num_rows()>0) 
		return $query->row();
	else
		return FALSE;
}

public function get_resultbylimit($table_name='',$limit="",$id_array='',$id_array2=''){
         $this->db->limit($limit);
        if(!empty($id_array)):      
            foreach ($id_array as $key => $value){
                $this->db->where($key, $value);
             
            }
       endif;
        if(!empty($id_array2)):     
            foreach ($id_array2 as $key => $value){
                $this->db->or_where($key, $value);
            }
        endif;
        $query=$this->db->get($table_name);
        if($query->num_rows()>0)
            return $query->result();
        else
            return FALSE;
}

//---------========== Get Data Or operator =================------

public function getOrResult($table_name='',$id_array=''){

    if(!empty($id_array)):     

        $this->db->or_where($id_array);
    endif;
    $query=$this->db->get($table_name);
    if($query->num_rows()>0)
        return $query->result();
    else
        return FALSE;
}

//---------========== Get Data Using Clause =================------

public function getInClauseData($select='',$table_name='',$colName='',$arr='',$where=''){

 if ($select != '')
    $this->db->select($select);

if(count($where)>0)
    $this->db->where($where);

$this->db->where_in($colName, $arr);

$query=$this->db->get($table_name);
if($query->num_rows()>0)
    return $query->result();
else
    return FALSE;
}

//---------========== Get Data Using Join=================------

public function getJoinData($seldata,$table1='',$table2='',$join_condition='',$wh='',$orderby='id',$orderformat='asc',$resultType="",$limit="",$start=""){

    $this->db->select($seldata);

    $this->db->from($table1);

    $this->db->join($table2,$join_condition);
	if(!empty($wh))
    $this->db->where($wh);

    $this->db->order_by($orderby, $orderformat);



    if($limit!="" && $start!="")
    {
        $this->db->limit($limit,$start);
    }
    else if($limit!="")
    {
        $this->db->limit($limit);
    }
        
    $query = $this->db->get();
    
    if(empty($resultType)){
        $query->result();
    }else{
        if($resultType=='result_array'){
           return $query->result_array();
        }elseif($resultType=='row_array'){
            return $query->row_array();
        }elseif($resultType=='row'){
            return $query->row();
        }
    }
}

    public function getsingleJoinData($seldata,$table1='',$table2='',$join_condition='',$wh=''){

        $this->db->select($seldata);

        $this->db->from($table1);

        $this->db->join($table2,$join_condition);
        if(!empty($wh))
        $this->db->where($wh);

      
            
        $query = $this->db->get();
        

        return $query->row_array();

    }

/* End of file generalmodel.php */
public function get_all_record($table)
    {
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) 
        {
            return $query->result_array();
        } 
        else 
        {
            return array();
        }
    }

public function get_data_by_condition($data,$table,$condition)
    {
         $this->db->select($data);
        $query=$this->db->from($table);
        $query=$this->db->where($condition);
        $query=$this->db->get();
        //echo $this->db->last_query(); die();
        return $query->result_array();
        //$this->db->close();
    } 
    public function business_suggession($term){

        $where1 = "AND `contact`.`status`='1'";
        $where1 = "";

        $where = "`business_name` like '$term%' AND `business`.`status` = '1'";
        $this->db->select('GROUP_CONCAT(business.business_id SEPARATOR ",") AS ids');
        $this->db->from('business'); 
        $this->db->join('contact','contact.business_id = business.business_id');       
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

    public function threetables($data,$table1,$table2,$table3,$on,$on2,$condition,$where)
    {
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        $this->db->join($table3,$on2);
        $this->db->where($condition);
        if($where!="")
        {
            $this->db->where($where);
        }
        $query=$this->db->get();
        //return $this->db->last_query();
        return $query->result_array();
    }

     public function threetablesall($data,$table1,$table2,$table3,$on,$on2,$where)
    {
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        $this->db->join($table3,$on2);
       if($where!="")
        {
            $this->db->where($where);
        }
        $query=$this->db->get();
        //return $this->db->last_query();
        return $query->result_array();
    }

    public function cp_suggession($term){
        $where = "`contact_person` like '%$term%' AND `contact.status`=1  AND `business.status`=1";
        $this->db->select('contact_id,contact_person,business.business_id,business_name');
        $this->db->from('contact'); 
        $this->db->join('business','contact.business_id = business.business_id');       
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();        
    }


    public function add_deal($busData,$cpData,$dealData){

        $this->db->trans_start();
        
        $this->db->insert('business', $busData);
        $bus_id = $this->db->insert_id();        

        $cpData['business_id'] = $bus_id;
        $this->db->insert('contact', $cpData);
        $cp_id = $this->db->insert_id();


        $dealData['business_id'] = $bus_id;
        $dealData['contact_id'] = $cp_id;  
        $this->db->insert('deal', $dealData);
        $dealid = $this->db->insert_id();

        $this->db->trans_complete();
        return $dealid;
    }

    public function user_cartvalue($uid){
        $cartdata = $this->getparticularData("SUM(prod_price) as total",'cart',array("createdby"=>$uid),'row_array');
        if(!empty($cartdata['total'])){
            $cartvalue=$cartdata['total'];
        }else{
            $cartvalue =0;
        }
        return $cartvalue;
    }

    public function form_templates($where){
        return $this->getparticularData("frm_manager_id,frm_template_name,frm_manager_fields,frm_createdate,frm_status","form_manager",$where,"result_array");
    }

    public function all_suppliers(){
        return $this->db->select("supplier_id,CONCAT_WS(' ',`firstname`,`lastname`) AS username")->from('user')->join('supplier','supplier.user_id= user.user_id','left')->where(array('status'=>1,'urole_id'=>5))->get()->result_array();
    }

    public function lic_ia_ofconsumer($cid){
        $data = $this->db->query('SELECT `resource_id`,`createdby` from user WHERE user_id='.$cid)->row_array();
        $ia_id = $data['createdby'];
        $return['consumer'] = $data['resource_id'];

        $ia_data = $this->db->query('SELECT `resource_id`,`createdby` from user WHERE user_id='.$ia_id)->row_array();
        
        $return['ia'] = $ia_data['resource_id'];
        $li_id = $ia_data['createdby'];

        $li_data = $this->db->query('SELECT `resource_id` from user WHERE user_id='.$li_id)->row_array();
        $return['lic'] = $li_data['resource_id'];
        return $return;
    }

    public function consumerList($ia_id=""){
        $where = "`status`=1 AND `urole_id`=4";
        if(!empty($ia_id)){
            $where .=" AND `createdby`=$ia_id";
        }
        $result = $this->db->select('user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS fullname') 
        ->from('user')
        ->where($where)->get()->result_array();
        return $result;     
    }

    public function consumer_products($cid){

        $where = array('orders.createdby'=>$cid);
        $this->db->select('GROUP_CONCAT(DISTINCT ord_prod_id SEPARATOR ",") AS pro_id'); 
        $this->db->from('orders');
        $this->db->join('orders_product','orders.orders_id = orders_product.orders_id','LEFT');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array(); 
    }

    public function ia_customer_ids($ia_id){
        $where = array('urole_id'=>4,'createdby'=>$ia_id);
        $this->db->select('GROUP_CONCAT(user_id SEPARATOR ",") AS ids'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();      
    }

    public function all_consumers($createdby=""){
        $where = "`status`=1 AND `urole_id`=4";
        if(!empty($createdby)){
            $where .=" AND `createdby`=$createdby";
        }
        $result = $this->db->select('user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS fullname') 
        ->from('user')
        ->where($where)->get()->result_array();
        return $result; 
    }

    public function ia_list_of_lic($lic){
        $where = array('urole_id'=>3,'createdby'=>$lic);
        $this->db->select('GROUP_CONCAT(user_id SEPARATOR ",") AS ids'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();      
    }

    public function getlicdata($userid){
        return $this->db->select('*')->from('licensee')->where(array('user_id'=>$userid))->get()->row_array();
    }
    
}


/* Location: ./application/models/generalmodel.php */