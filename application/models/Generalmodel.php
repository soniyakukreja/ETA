<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Generalmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }

//=============curd operation=============

    public function add($tableName, $data) {

        $this->db->insert($tableName, $data);
        return $this->db->insert_id();
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
    public function deleterecord($table,$where){
        return $this->db->delete($table,$where);
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
    //=============curd operation=============


    public function mail_template($select,$type){
        return $this->getparticulardata($select,'email_template',array('type'=>$type,'status'=>'1'),'row_array');
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

public function getPaginationData($tableName, $filters = '', $perPage, $start, $orderby, $orderformat,$selectData=''){
 
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

public function get_pagination_result($table_name='',$id_array='',$limit='',$offset='',$orderid,$order='')
{     
       
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

public function customjoin($seldata,$table1='',$table2='',$table3='',$table4='',$join_condition='',$wh=''){

    $this->db->select($seldata);

    $this->db->from($table1,$table2,$table3,$table4);
    
    if(!empty($join_condition))
    $this->db->where($join_condition);

    $query = $this->db->get();
    

    return $query->row_array();

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

public function get_data_by_condition($data,$table,$condition){
    $this->db->select($data);
    $query=$this->db->from($table);
    $query=$this->db->where($condition);
    $query=$this->db->get();
    //echo $this->db->last_query(); die();
    return $query->result_array();
    //$this->db->close();
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

//==============project functions===========

    public function cp_suggession($term){
        $where = "`contact_person` like '%$term%' AND `contact.status`=1  AND `business.status`=1";
        $this->db->select('contact_id,contact_person,business.business_id,business_name');
        $this->db->from('contact'); 
        $this->db->join('business','contact.business_id = business.business_id');       
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();        
    }


    public function check_user_exist($email,$id=''){
        $where = "`email`='$email'";
        if(!empty($id)){ $where .= " AND `user_id` !=$id"; }
        return $this->db->select('email')->from('user')->where($where)->get()->row_array();
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

    // public function user_cartvalue($uid){
    //     $cartdata = $this->getparticularData("SUM(prod_price) as total",'cart',array("createdby"=>$uid),'row_array');
    //     if(!empty($cartdata['total'])){
    //         $cartvalue=$cartdata['total'];
    //     }else{
    //         $cartvalue =0;
    //     }
    //     return $cartvalue;
    // }

    public function user_cartData($uid){
        return $this->getparticularData("SUM(prod_price) as pricetotal, SUM(prod_qty) AS qtytotal",'cart',array("createdby"=>$uid),'row_array');
    }

    public function form_templates($where){
        return $this->getparticularData("frm_manager_id,frm_template_name,frm_manager_fields,frm_createdate,frm_status","form_manager",$where,"result_array");
    }

    //====lists============
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

    public function liccategorylist(){
        $urole_id = 2;
        $query = $this->db->select('user_cat_id as id, user_cat_name as name')
        ->from('user_category')
        ->where(array('user_cat_status'=>'1','roles_id'=>$urole_id))
        ->order_by('name','ASC')->get()->result_array();
        return $query;
    }

    public function iacategorylist(){
        $urole_id = 3;
        $query = $this->db->select('user_cat_id as id, user_cat_name as name')
        ->from('user_category')
        ->where(array('user_cat_status'=>'1','roles_id'=>$urole_id))
        ->order_by('name','ASC')->get()->result_array();
        return $query;
    }

    public function prod_cat_list(){
        $urole_id = $this->userdata['urole_id'];
        $query = $this->db->select('prod_cat_id, prod_cat_name')
        ->from('product_category')
        ->where(array('prod_cat_status'=>'1'))
        ->order_by('prod_cat_name','ASC')->get()->result_array();
        return $query;
    }    

    public function deptlist(){
        return $this->db->select('*')->from('department')->order_by('deptname','ASC')->get()->result_array();   
    }

    public function kam_list(){
        $user_id = $this->userdata['user_id'];
        return $this->db->select("user_id,CONCAT_WS(' ',`firstname`,`lastname`) AS username")
        ->from('user')
        ->where("`status`=1 AND `dept_id`='5' AND `createdby`=$user_id")
        ->get()->result_array();
    }

    public function all_licensee(){
/*        $where = "`status`=1 AND `urole_id`=2";
        $result = $this->db->select('user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS username') 
        ->from('user')
        ->where($where)->get()->result_array();
        return $result; */

        $where = "`user`.`status`=1 AND `lic`.`status`='1' AND `urole_id`=2";
        $result = $this->db->select('user.user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS username,b.business_name,b.business_id') 
        ->from('user')
        ->join('licensee as lic','lic.user_id=user.user_id')
        ->join('business as b','b.business_id=lic.business_id')
        ->where($where)
        ->order_by('b.business_name','ASC')
        ->get()->result_array();

        // echo $this->db->last_query();
        // echo "<pre>"; print_r($result); exit;
        return $result;     

    }

    public function supplier_detail($uid='',$sid=''){
        
        $where = "`user`.`status`=1 AND b.status='1'  AND supplier.supplier_status='1' AND `urole_id`=5";
        
        if(!empty($uid)){ $where .=" AND user.user_id=".$uid; }
        
        if(!empty($sid)){ $where .=" AND supplier.supplier_id=".$sid; }

        return $this->db->select("supplier.*,user.*,b.business_id,b.business_name")
        ->from('user')
        ->join('supplier','supplier.user_id= user.user_id','left')
        ->join('business AS b','b.business_id=supplier.business_id')
        ->where($where)->get()->row_array();

    }

    public function all_ialist(){
        $where = "`status`=1 AND `urole_id`=3";
        $result = $this->db->select('user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS username') 
        ->from('user')
        ->where($where)->get()->result_array();
        return $result; 
    }

    public function all_suppliers(){
        return $this->db->select("supplier_id,CONCAT_WS(' ',`firstname`,`lastname`) AS username,b.business_id,b.business_name")
        ->from('user')
        ->join('supplier','supplier.user_id= user.user_id','left')
        ->join('business AS b','b.business_id=supplier.business_id')
        ->where("`user`.`status`=1 AND b.status='1' AND supplier.supplier_status='1' AND `urole_id`=5")->get()->result_array();
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

    public function lic_ia_ofconsumer($cid){
        $data = $this->db->query('SELECT `resource_id`,`createdby`,CONCAT_WS(" ",`firstname`,`lastname`) AS username from user WHERE user_id='.$cid)->row_array();
        $ia_id = $data['createdby'];
        $return['consumer'] = $data['resource_id'];
        $return['consumername'] = $data['username'];

        $ia_data = $this->db->query('SELECT user_id,email,`resource_id`,`createdby`,CONCAT_WS(" ",`firstname`,`lastname`) AS username from user WHERE user_id='.$ia_id)->row_array();
        
        $return['ia'] = $ia_data['resource_id'];
        $li_id = $ia_data['createdby'];
        $return['ianame'] = $ia_data['username'];
        $return['ia_userid'] = $ia_data['user_id'];
		$return['ia_email'] = $ia_data['email'];

        $li_data = $this->db->query('SELECT user_id,email,`resource_id`,CONCAT_WS(" ",`firstname`,`lastname`) AS username from user WHERE user_id='.$li_id)->row_array();
        $return['lic'] = $li_data['resource_id'];
        $return['licname'] = $li_data['username'];
        $return['lic_userid'] = $li_data['user_id'];
		$return['lic_email'] = $li_data['email'];

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
    public function iaList($lic_id=""){
        $where = "`user`.`status`=1 AND `ia`.`status`='1' AND `urole_id`=3";
        if(!empty($lic_id)){
            $where .=" AND `user`.`createdby`=$lic_id";
        }
        $result = $this->db->select('user.user_id,CONCAT_WS(" ",`firstname`,`lastname`) AS username,b.business_name,b.business_id') 
        ->from('user')
        ->join('indassociation as ia','ia.user_id=user.user_id')
        ->join('business as b','b.business_id=ia.business_id')
        ->where($where)->get()->result_array();
        return $result;     
    }    


    /*  public function ialist_of_lic($lic){
        $where = "`urole_id`=3 AND `createdby` IN($lic)";
        $this->db->select('CONCAT_WS(" ",firstname,lastname) AS username,user_id'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();      
    }

    public function ia_list_of_lic($lic){
        $where = array('urole_id'=>3,'createdby'=>$lic);
        $this->db->select('CONCAT_WS(" ",firstname,lastname) AS username,user_id'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();      
    }
   */     
    public function consumer_products($cid){

        $where = array('orders.createdby'=>$cid);
        $this->db->select('GROUP_CONCAT(DISTINCT ord_prod_id SEPARATOR ",") AS pro_id'); 
        $this->db->from('orders');
        $this->db->join('orders_product','orders.orders_id = orders_product.orders_id','LEFT');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array(); 
    }


    public function supplier_products($sid){

        $where = array('product.supplier_id'=>$sid);
        $this->db->select('product.prod_id,product.product_name'); 
        $this->db->from('product');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function ia_customer_ids($ia_id){
        $where = array('urole_id'=>4,'createdby'=>$ia_id);
        $this->db->select('GROUP_CONCAT(user_id SEPARATOR ",") AS ids'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();      
    }



    public function consumerlist_of_ia_of_lic($ia_ids){
        $where = "`urole_id`=4 AND `createdby` IN($ia_ids)";
        $this->db->select('CONCAT_WS(" ",firstname,lastname) AS username,user_id'); 
        $this->db->from('user');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();      
    }


    public function getlicdata($userid){
        return $this->db->select('lic.*,CONCAT_WS(" ",u.firstname,u.lastname) AS username,u.email,u.contactno')->from('licensee as lic')
        ->join('user as u','u.user_id = lic.user_id','LEFT')
        ->where(array('lic.user_id'=>$userid))->get()->row_array();
    }

    public function get_iadata($userid){
        return $this->db->select('ia.*,CONCAT_WS(" ",u.firstname,u.lastname) AS username,u.email,u.contactno,u.profilepicture as userprofile')
        ->from('indassociation as ia')
        ->join('user as u','u.user_id = ia.user_id','LEFT')
        ->where(array('ia.user_id'=>$userid))->get()->row_array(); 
    }


    public function get_consumerdata($userid){
        return $this->db->select('u.*,b.business_name,b.business_id')
        ->from('user as u')
        ->join('business as b','b.business_id = u.consumer_business_id','LEFT')
        ->where(array('u.user_id'=>$userid))->get()->row_array(); 
    }

    public function li_assigned_products($lic){

        $query = $this->db->select('p.prod_id,p.product_name')
        ->from('prodassigntolicensee as licp')
        ->join('product as p','p.prod_id = licp.prod_id')
        ->where(array('lic_id'=>$lic))->get()->result_array();
        return $query;
    }

    public function ia_assigned_products($ia){

        $query = $this->db->select('p.prod_id,p.product_name')
        ->from('prodassigntoia as iap')
        ->join('product as p','p.prod_id = iap.prod_id')
        ->where(array('ia_id'=>$ia))->get()->result_array();
        return $query;
    }
    
    public function ticket_cat_list(){
        $query = $this->db->select('tic_cat_id,tic_cat_name')
        ->from('ticket_category')
        ->where(array('tic_del_status'=>'1','tic_cat_status'=>'1'))
        ->order_by('tic_cat_name','ASC')->get()->result_array();
        return $query;       
    }

    public function interest_detail($intID){
        return $this->db->select('CONCAT_WS(" ",firstname,lastname) AS username,p.product_name,ie.int_id,ie.ia_id,ie.lic_id,ie.customer_id,ie.createdate')->from('interest_expression as ie')
        ->join('product as p','p.prod_id = ie.prod_id','LEFT')
        ->join('user as u','u.user_id = ie.customer_id','LEFT')
        ->where('ie.int_id='.$intID)
        ->get()->row_array();
    }

    public function get_user_resource_id($uid){
        $data = $this->db->select('resource_id')->from('user')->where('user_id',$uid)->get()->row_array();
        if(!empty($data)){ return $data['resource_id']; }else{return $data;}
    }


    public function get_supplier_resource_id($uid){
        $data = $this->db->select('resource_id')->from('supplier')
        ->join('user','user.user_id = supplier.user_id','LEFT')
        ->where('supplier_id',$uid)->get()->row_array();
        if(!empty($data)){ return $data['resource_id']; }else{return $data;}
    }

    public function get_Dealbusiness($dealid){
        return $this->db->select('business.business_id,business.business_name')
        ->from('business')
        ->join('deal','deal.business_id =business.business_id','left')
        ->where("deal.deal_id = $dealid")->get()->row_array();
    }

    public function get_my_bde(){
        $user_id = $this->userdata['user_id'];
        return $this->db->select("user_id,CONCAT_WS(' ',`firstname`,`lastname`) AS username")
        ->from('user')
        ->where("`status`=1 AND `dept_id`='11' AND `createdby`=$user_id")
        ->get()->result_array();
    }

    public function my_profile_data(){
        $userid= $this->userdata['user_id'];
        $role = $this->userdata['urole_id'];

        if($role==1){
            return $this->db->select('user.*,country.country_name')->from('user')
            ->join('country','user.country = country.id','left')
            ->where(array('user.user_id'=>$userid))->get()->row_array();

        }elseif($role==2){
           return $this->db->select('user.*,country.country_name,b.business_id,b.business_name')->from('user')
            ->join('country','user.country = country.id','left')
            ->join('licensee AS l','l.user_id = user.user_id','left')
            ->join('business AS b','b.business_id = l.business_id','left')
            ->where(array('user.user_id'=>$userid))->get()->row_array();

        }elseif($role==3){
           return $this->db->select('user.*,country.country_name,b.business_id,b.business_name')->from('user')
            ->join('country','user.country = country.id','left')
            ->join('indassociation AS ia','ia.user_id = user.user_id','left')
            ->join('business AS b','b.business_id = ia.business_id','left')
            ->where(array('user.user_id'=>$userid))->get()->row_array();

        }elseif($role==4){
            return $this->db->select('user.*,country.country_name,b.business_id,b.business_name')->from('user')
            ->join('country','user.country = country.id','left')
            ->join('business AS b','b.business_id = user.consumer_business_id','left')
            ->where(array('user.user_id'=>$userid))->get()->row_array();
        
        }elseif($role==5){
            return $this->db->select('user.*,country.country_name,b.business_id,b.business_name')->from('user')
            ->join('country','user.country = country.id','left')
            ->join('supplier AS s','s.user_id = user.user_id','left')
            ->join('business AS b','b.business_id = s.business_id','left')
            ->where(array('user.user_id'=>$userid))->get()->row_array();

        }
    }

    public function business_suggession($term){
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

    public function get_supplier_of_business($business_id,$supplier_id=''){
        $where ="s.business_id=".$business_id; 
        if(!empty($supplier_id)){  $where .=" AND s.supplier_id !=".$supplier_id; }

        return $this->db->query("SELECT `b`.business_id,`b`.business_name ,s.supplier_id
        FROM `supplier` AS s
        JOIN  `business` AS b ON `s`.`business_id` = `b`.`business_id` AND `b`.`status` !='2'
        WHERE $where")
        ->row_array();        
    }

    public function ticketDetail($tic_id){

        return $this->db->query("SELECT *
        FROM `ticket` AS t
        JOIN `ticket_category` AS tc ON `t`.`tic_cat_id` = `tc`.`tic_cat_id` WHERE `t`.`tic_id` ='".$tic_id."' AND `t`.`status`='1'")->row_array();

    }

    public function lic_ia_assignee($id){
        return $this->db->query("SELECT *
        FROM `user` AS u
        WHERE `u`.`user_id` ='".$id."'")->row_array();
    }

    public function audit_detail($aud_prod_id='',$ord_id=''){


        $orderDetail = $this->db->select('au.ord_prod_id,au.audit_num, au.businessname, au.status,au.updatedate,au.issue_date,au.end_date,
            au.certificate_file,au.file,au.prod_name,sh.*,b.*,o.is_billing_same,o.add_fields')
        ->from('audit as au')
        ->join('orders as o','o.orders_id = au.orders_id')
        ->join('shipping_address as sh','sh.shipping_id = o.shipping_id','LEFT')
        ->join('billing_address as b','b.billing_id = o.billing_id','LEFT')
        ->where("au.ord_prod_id = $aud_prod_id")
        ->get()->row_array();


        // ->join('paymentdetail as pd','pd.pay_id = o.pay_id','LEFT')
       
        return $orderDetail;

    }



    /*
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
    */

}


/* Location: ./application/models/generalmodel.php */