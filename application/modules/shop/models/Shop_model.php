<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Shop_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getcount($catid=''){
        if(!empty($catid)){
            $where = array('prod_status'=>'1','prod_cat_id'=>$catid);
        }else{
            $where = array('prod_status'=>'1');
        }

        $result =  $this->db->select('Count("id") AS total ')->from("product")->where($where)->get()->row_array();
    	return $result['total'];
    }

    public function prod_suggessions($term,$exception=''){
        $where = "(`product_name` like '$term%' OR `product_sku` like '$term%') AND prod_status = '1'";
        
        if(!empty($exception)){
            $where .=" AND prod_id IN(".$exception.")";
        }
        $this->db->select('prod_id,product_name');
        $this->db->from('product');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array(); 

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

    public function getproductDetail($id){
        return $this->db->select('*')->from("product")->where(array('prod_id'=>$id,'prod_status'=>1))->get()->row_array();
    }

    public function check_inactive_products($prod_ids){
        return $this->db->select('product_sku,product_name')->from("product")
        ->where("`prod_id` IN(".$prod_ids.") AND `prod_status`=0")->get()->result_array();
    }

    public function add_order($billingData,$shipData,$payData,$orderData,$prodData,$createdby,$auditArr){

        $this->db->trans_start();

        $this->db->insert('billing_address', $billingData);
        $orderData['billing_id'] = $this->db->insert_id();

        if(!empty($shipData)){
            $this->db->insert('shipping_address', $shipData);
            $orderData['shipping_id'] = $this->db->insert_id();
        }

 
        // $this->db->insert('paymentdetail', $payData);
        // $orderData['pay_id'] =  $this->db->insert_id();
        //$orderData['pay_id'] =  0;


        $this->db->insert('orders', $orderData);
        $lastid =  $this->db->insert_id();

        foreach($prodData as $key=>$prod){
            $prodData[$key]['orders_id'] =$lastid;
        }
        if(!empty($auditArr)){
            foreach($auditArr as $k=>$aud){
                $auditArr[$k]['orders_id'] =$lastid;
                $str = substr($aud['prod_name'],0,3);
                $audit_num = $lastid.'-'.$str.'-'.$aud['prod_id'];
                $auditArr[$k]['audit_num'] =$audit_num;
            }
			$this->db->insert_batch('audit', $auditArr);
        }
        $this->db->insert_batch('orders_product', $prodData);
        
        $this->db->delete('cart',array('createdby'=>$createdby));
        $this->db->trans_complete();
        return $lastid;
    }

    public function order_summary($oid,$onlyaudit=""){
        
        if($onlyaudit==true){

            $orderDetail['products'] = $this->db->select('p.prod_id,p.supplier_id,op.prod_name,op.prod_price,op.prod_qty,op.prod_total,p.type,op.dis_percent,op.prod_dis,au.status AS audit_status')
            ->from('orders_product as op')
            ->join('product as p','p.prod_id = op.prod_id')
            ->join('audit as au','au.prod_id = op.prod_id AND au.orders_id='.$oid,'LEFT')
            ->where("op.orders_id = $oid AND p.type='Audit'")
            ->get()->result_array();


        }else{
            $orderDetail['products'] = $this->db->select('op.prod_name,op.prod_price,op.prod_qty,op.prod_total,p.type,op.dis_percent,op.prod_dis')
            ->from('orders_product as op')
    		->join('product as p','p.prod_id = op.prod_id')
            ->where("op.orders_id = $oid")
            ->get()->result_array();
		}

		$orderDetail['detail'] =  $this->db->select('sh.*,b.*,o.*,pd.lastfour')
        ->from('orders as o')
        ->join('shipping_address as sh','sh.shipping_id = o.shipping_id','LEFT')
		->join('billing_address as b','b.billing_id = o.billing_id','LEFT')
		->join('paymentdetail as pd','pd.pay_id = o.pay_id','LEFT')
        ->where("o.orders_id = $oid")
        ->get()->row_array();
		//print_r($this->db->last_query()); exit;
		
		return $orderDetail;
    }

}