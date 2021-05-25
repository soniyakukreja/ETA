<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Shop extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
        $this->load->model("Shop/shop_model");
    }
    
    public function index()
    {
        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");
        $this->load->view('shop/shop',$data);
    }

    public function loadproducts(){
        $catid = $_GET['catid'];
        $sort = $_GET['sort'];

        switch ($sort) {
            case 'name_asc':
                $order_by = "product_name ASC" ;
                break;
            case 'name_desc':
                $order_by = "product_name DESC" ;
                break;
            case 'price_asc':
                $order_by = "c_price ASC" ;
                break;
            case 'price_desc':
                $order_by = "c_price DESC" ;
                break;
            case 'date_asc':
               $order_by = "createdate ASC" ;
                break;
            case 'date_desc':
               $order_by = "createdate DESC" ;
                break;
            default:
                $order_by = "product_name ASC" ;
                break;
        }



        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["per_page"] = 12;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] =TRUE;
        $config["full_tag_open"] ="<ul class='pagination'>";
        $config["full_tag_close"] ="</ul>";
        $config["first_tag_open"] ="<li>";
        $config["first_tag_close"] ="</li>";
        $config["last_tag_open"] ="<li>";
        $config["last_tag_close"] ="</li>";
        $config["next_link"] ="&gt;";
        $config["next_tag_open"] ="<li>";
        $config["next_tag_close"] ="</li>";
        $config["prev_link"] ="&lt;";
        $config["prev_tag_open"] ="<li>";
        $config["prev_tag_close"] ="</li>";
        
        $config["cur_tag_open"] ="<li class='active'><a href='#'>";
        $config["cur_tag_close"] ="</a></li>";
        $config["num_tag_open"] ="<li>";
        $config["num_tag_close"] ="</li>";
        $config["num_links"] =1;

        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
        $start = ($page -1)*$config["per_page"];
        
        if(!empty($catid)){
            $where = array('prod_status'=>'1','prod_cat_id'=>$catid);
        }else{
            $where = array('prod_status'=>'1');
        }

        $data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");

        
        $product_where = "";
        $createdby = $this->userdata['createdby'];
        $user_level = $this->userdata['user_level'];


        //=====consumer created by ia============
        if($user_level==3){

            $assign = $this->shop_model->getparticularData("ia_prod_assign,ia_id,createdby",'indassociation',array('user_id'=>$createdby,'status'=>'1'),"row_array");
            if($assign['ia_prod_assign']==1){
                $product_where = "prodassigntoia.ia_id=".$assign['ia_id'];

                $where["prodassigntoia.ia_id"] = $assign['ia_id'];
                $where["prodassigntoia.status"] = '1';
                $tables[0]['table'] = 'prodassigntoia';
                $tables[0]['on'] = 'product.prod_id = prodassigntoia.prod_id';
                $data['products']=$this->generalmodel->getfrommultipletables("product.*","product", $tables,$where,"",$order_by,$config["per_page"],$start,"result_array");      
                
                $total_products = $this->generalmodel->getfrommultipletables("COUNT(product.prod_id) AS totalprod","product", $tables,$where,"","","","","row_array");

            }else{
                $lic_of_ia = $assign['createdby'];

                $assign = $this->shop_model->getparticularData("lic_prod_assign,lic_id",'licensee',array('user_id'=>$lic_of_ia,'status'=>'1'),"row_array");
                if($assign['lic_prod_assign']==1){
                    $product_where = "prodassigntolicensee.lic_id=".$assign['lic_id'];

                    $where["prodassigntolicensee.lic_id"] = $assign['lic_id'];
                    $where["prodassigntolicensee.status"] = '1';
                    $tables[0]['table'] = 'prodassigntolicensee';
                    $tables[0]['on'] = 'product.prod_id = prodassigntolicensee.prod_id';
                    $data['products']=$this->generalmodel->getfrommultipletables("product.*","product", $tables,$where,"",$order_by,$config["per_page"],$start,"result_array");      

                    $total_products = $this->generalmodel->getfrommultipletables("COUNT(product.prod_id) AS totalprod","product", $tables,$where,"","","","","row_array");
                
                }
            }
        //=====consumer created by licensee============    
        }elseif($user_level==2){

            $assign = $this->shop_model->getparticularData("lic_prod_assign,lic_id",'licensee',array('user_id'=>$createdby,'status'=>'1'),"row_array");
            if($assign['lic_prod_assign']==1){
                $product_where = "prodassigntolicensee.lic_id=".$assign['lic_id'];

                $where["prodassigntolicensee.lic_id"] = $assign['lic_id'];
                $where["prodassigntolicensee.status"] = '1';

                $tables[0]['table'] = 'prodassigntolicensee';
                $tables[0]['on'] = 'product.prod_id = prodassigntolicensee.prod_id';
                $data['products']=$this->generalmodel->getfrommultipletables("product.*","product", $tables,$where,"",$order_by,$config["per_page"],$start,"result_array");      
                $total_products = $this->generalmodel->getfrommultipletables("COUNT(product.prod_id) AS totalprod","product", $tables,$where,"","","","","row_array");
            }
        }

        if(empty($product_where)){
            $data['products'] = $this->shop_model->getparticularData("*",'product',$where,"result_array",$config["per_page"],$start,$order_by);

            $total_products = $this->generalmodel->getparticularData("COUNT(product.prod_id) AS totalprod","product",$where,"row_array");
        }

        $config["total_rows"] = $total_products['totalprod'];
        $this->pagination->initialize($config);

        $output['html'] = $this->load->view('shop/ajax_prod_list',$data,true);
        $output['links'] = $this->pagination->create_links();

        echo json_encode($output);
    }

    public function prod_suggessions(){
        $response=array();
        if($this->input->is_ajax_request()){
            if(isset($_POST['term'])){
                
                $term=$this->input->post('term');
                $result=$this->shop_model->prod_suggessions($term);

                $product_where = "";
                $createdby = $this->userdata['createdby'];
                $user_level = $this->userdata['user_level'];


                //=====consumer created by ia============
                if($user_level==3){

                    $assign = $this->shop_model->getparticularData("ia_prod_assign,ia_id,createdby",'indassociation',array('user_id'=>$createdby,'status'=>'1'),"row_array");
                    if($assign['ia_prod_assign']==1){
                        $product_where = "prodassigntoia.ia_id=".$assign['ia_id'];

                        $where["prodassigntoia.ia_id"] = $assign['ia_id'];
                        $where["prodassigntoia.status"] = '1';
                        $tables[0]['table'] = 'prodassigntoia';
                        $tables[0]['on'] = 'product.prod_id = prodassigntoia.prod_id';
                        $products=$this->generalmodel->getfrommultipletables("GROUP_CONCAT(product.prod_id SEPARATOR ',') AS ids","product", $tables,$where,"","","","","row_array");      
                    

                    }else{
                        $lic_of_ia = $assign['createdby'];

                        $assign = $this->shop_model->getparticularData("lic_prod_assign,lic_id",'licensee',array('user_id'=>$lic_of_ia,'status'=>'1'),"row_array");
                        if($assign['lic_prod_assign']==1){
                            $product_where = "prodassigntolicensee.lic_id=".$assign['lic_id'];

                            $where["prodassigntolicensee.lic_id"] = $assign['lic_id'];
                            $where["prodassigntolicensee.status"] = '1';
                            $tables[0]['table'] = 'prodassigntolicensee';
                            $tables[0]['on'] = 'product.prod_id = prodassigntolicensee.prod_id';
                            $products=$this->generalmodel->getfrommultipletables("GROUP_CONCAT(product.prod_id SEPARATOR ',') AS ids","product", $tables,$where,"","","","","row_array");      
                        }
                    }
                //=====consumer created by licensee============    
                }elseif($user_level==2){

                    $assign = $this->shop_model->getparticularData("lic_prod_assign,lic_id",'licensee',array('user_id'=>$createdby,'status'=>'1'),"row_array");
                    if($assign['lic_prod_assign']==1){
                        $product_where = "prodassigntolicensee.lic_id=".$assign['lic_id'];

                        $where["prodassigntolicensee.lic_id"] = $assign['lic_id'];
                        $where["prodassigntolicensee.status"] = '1';
                        
                        $tables[0]['table'] = 'prodassigntolicensee';
                        $tables[0]['on'] = 'product.prod_id = prodassigntolicensee.prod_id';
                        $products=$this->generalmodel->getfrommultipletables("GROUP_CONCAT(product.prod_id SEPARATOR ',') AS ids","product", $tables,$where,"","","","","row_array");      
                    }
                }

                if(!empty($products)){
                    $exception= $products['ids'];
                }else{
                    $exception= '';
                }

               
                $result=$this->shop_model->prod_suggessions($term,$exception);

                $resultData='';
                $recordFound=0;
                if(!empty($result)){
                    foreach($result as $cr){
                        $resultData.='<li class="prod_item list-group-item" data-val="'.$cr['prod_id'].'">'.$cr['product_name'].'</li>';
                    }
                    $response['status']='success';
                    $response['data']=$resultData;
                }else{
                    $response['status']='fail';
                }
            }else{
                $response['status']='fail';
                $response['message']='Invalid API key 1';
            }
        }else{
            $response['status']='fail';
            $response['message']='Invalid API key 2';
        }
        print_r(json_encode($response));
    }

    public function prod_detail($pid){
        //$id = decode_id($pid,'id');
        $id = $pid;
        $tables[0]['table'] = 'cart';
        $tables[0]['on']    = 'product.prod_id=cart.prod_id';
        $data['product'] = $this->generalmodel->getfrommultipletables("cart.*,product.*",'product', $tables,array('prod_status'=>'1','product.prod_id'=>$id),"","","","","row_array");
        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");

        $data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");
        
        $this->load->view('shop/product_detail',$data); 
    }

    public function update_cart(){

        if($this->input->is_ajax_request() && !empty($_POST)){

            $cartUpdate = false;
            $prod_ids = $this->input->post('prodid');
            $prod_qty = $this->input->post('qty');

            if(!empty($prod_ids)){ 

                $prod_id_str = implode(',',$prod_ids);
                $inactive_prod = $this->shop_model->check_inactive_products($prod_id_str);

                if(!empty($inactive_prod)){

                    if(count($inactive_prod)>1){
                        $msg = "Following Products are no longer available ";
                        foreach($inactive_prod as $value){
                          $msg .= $value['product_name']."<br>"  ;
                        } 
                    }else{
                        $msg = $inactive_prod[0]['product_name']." is no longer available ";
                    }
                    
                    $return = array('success'=>false,'msg'=>'post empty');        
                    echo json_encode($return); exit;                
                }

                foreach($prod_ids as $key=>$prodid){

                    $product = $this->shop_model->getproductDetail($prodid);

                    if(!empty($product)){

                        $qty = $prod_qty[$key];
                        $createdate = date('Y-m-d h:i:s');
                        $dicount = $product['prod_dis'];
                        
                        if(!empty($product['prod_dis'])){
                            $disc_start = strtotime($product['prod_dis_startdate']);
                            $disc_end = strtotime($product['prod_dis_enddate']);
                            if(strtotime($createdate) <=$disc_start && strtotime($createdate)>=$disc_end){
                                $dicount = 0;
                            }
                        }

                        $where['prod_id'] = $prodid;
                        $where['createdby'] = $this->userdata['user_id'];
                        //$where['cart_id'] = $cartid;

                        $data['prod_price'] = $product['c_price'];
                        $data['prod_qty'] = round($qty,2);
                        $data['prod_dis'] = $dicount;
                        $data['createdate'] = $createdate;

                        $this->generalmodel->updaterecord('cart', $data,$where);
                    }  
                    $return = array('success'=>true,'msg'=>'Cart updated successfully!');
                } 
            }

        }else{
            $return = array('success'=>false,'msg'=>'post empty');
        }
        echo json_encode($return); exit;    
    }

    public function shop_filter_page(){
        if($this->input->is_ajax_request()){
            if(!empty($_POST['search'])){
                $data['product'] = $this->generalmodel->getparticularData("*",'product',array('prod_status'=>'1','prod_id'=>$_POST['search']),"row_array");
                $data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");
                echo $this->load->view('shop/ajax_shop',$data,true); 
            }
        }
    }

    public function addtocart(){
        if($this->input->is_ajax_request() && !empty($_POST)){
            
            if($this->form_validation->run('addtocart')){
                
                $id= $this->input->post('pid');
                $product = $this->shop_model->getproductDetail($id);
                if(!empty($product)){

                    $already_exist = $this->generalmodel->getparticularData("cart_id,prod_id",'cart',array('prod_id'=>$id,'createdby'=>$this->userdata['user_id']),"row_array");

                    if(empty($already_exist)){
                        $qty = empty($this->input->post('qty'))?1:$this->input->post('qty');
                        $createdate = date('Y-m-d h:i:s');
                        $dicount = $product['prod_dis'];
                        
                        
                        if(!empty($product['prod_dis'])){
                            $disc_start = strtotime($product['prod_dis_startdate']);
                            $disc_end = strtotime($product['prod_dis_enddate']);
                            if(strtotime($createdate) <=$disc_start && strtotime($createdate)>=$disc_end){
                                $dicount = 0;
                            }
                        }

                        $data['prod_id'] = $id;
                        $data['prod_cat_id'] = $product['prod_cat_id'];
                        $data['prod_price'] = $product['c_price'];
                        $data['prod_qty'] = round($qty,2);
                        $data['prod_dis'] = $dicount;
                        $data['createdby'] = $this->userdata['user_id'];
                        $data['createdate'] = $createdate;
                        $this->generalmodel->add('cart', $data);

                        $cartvalue = $this->generalmodel->user_cartvalue($this->userdata['user_id']);
                        $this->session->set_userdata('cartvalue',$cartvalue);    

                        $return = array('success'=>true,'msg'=>'Product added to  your cart successfully');
                    }else{
                        $return = array('success'=>true,'msg'=>'Product is already exist in your cart');
                    }    
                }              
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }

        }else{
            $return = array('success'=>false,'msg'=>'post empty');
        }
        echo json_encode($return); exit;
    }

    public function your_cart(){
        $tables[0]['table'] = 'cart';
        $tables[0]['on']    = 'product.prod_id=cart.prod_id';
        $data['products'] = $this->generalmodel->getfrommultipletables("product.*, cart.*",'product', $tables,array('prod_status'=>'1','cart.createdby'=>$this->userdata['user_id']),"","","","","result_array");
        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");
        $this->load->view('shop/your_cart',$data);  
    }

    public function remove_fromcart(){
        if($this->input->is_ajax_request() && !empty($_POST)){
            $cartid = $this->input->post('cartid');
            $query = $this->generalmodel->deleterecord('cart',array('cart_id'=>$cartid,'createdby'=>$this->userdata['user_id']));
            
            //====reset cart in session=====

            $cartvalue = $this->generalmodel->user_cartvalue($this->userdata['user_id']);
            $this->session->set_userdata('cartvalue',$cartvalue);

            $return = array('success'=>true,'msg'=>'Product removed from cart!');
        }else{
            $return = array('success'=>false,'msg'=>'post empty');
        }
        echo json_encode($return); exit;
    }

    public function updatecart(){
        if($this->input->is_ajax_request() && !empty($_POST)){

            $cartid = $this->input->post('cartid');
            $prodid = $this->input->post('prodid');
            $qty = $this->input->post('qty');

            $product = $this->shop_model->getproductDetail($prodid);

            if(!empty($product)){

                $createdate = date('Y-m-d h:i:s');
                $dicount = $product['prod_dis'];
                
                if(!empty($product['prod_dis'])){
                    $disc_start = strtotime($product['prod_dis_startdate']);
                    $disc_end = strtotime($product['prod_dis_enddate']);
                    if(strtotime($createdate) <=$disc_start && strtotime($createdate)>=$disc_end){
                        $dicount = 0;
                    }
                }

                $where['prod_id'] = $prodid;
                $where['createdby'] = $this->userdata['user_id'];
                $where['cart_id'] = $cartid;

                $data['prod_price'] = $product['c_price'];
                $data['prod_qty'] = round($qty,2);
                $data['prod_dis'] = $dicount;
                $data['createdate'] = $createdate;

                $query = $this->generalmodel->updaterecord('cart', $data,$where);
                
                if($query){

                    $cartvalue = $this->generalmodel->user_cartvalue($this->userdata['user_id']);
                    $this->session->set_userdata('cartvalue',$cartvalue);                    
                    $return = array('success'=>true,'msg'=>'Product updated successfully!');
                }else{
                    $return = array('success'=>false,'msg'=>'Product updated failed!');
                }
            }   
        }else{
            $return = array('success'=>false,'msg'=>'post empty');
        }
        echo json_encode($return); exit;        
    }


    public function checkout(){

        if($this->input->is_ajax_request() && !empty($_POST)){ 
            if($this->form_validation->run('add_order')){

                $createddate = $updatedate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];

                //======card data=====//
                $card_number = $this->input->post('card_number');
                $month = $this->input->post('month');
                $year = $this->input->post('year');
                $cvc = $this->input->post('cvc');
                $stripeToken = $this->input->post('stripeToken');

                //==========billing data============//
                $billingData['billing_fname'] = $this->input->post('fname');
                $billingData['billing_lname'] = $this->input->post('lname');
                $billingData['billing_email'] = $this->input->post('email');
                $billingData['billing_address'] = $this->input->post('address');
                $billingData['billing_alt_add'] = $this->input->post('alt_address');
                $billingData['billing_city'] = $this->input->post('city');
                $billingData['billing_state'] = $this->input->post('state');
                $billingData['billing_country'] = $this->input->post('country');
                $billingData['billing_postalcode'] = $this->input->post('postcode');
                $billingData['billing_createdate'] = $createddate;


                $shipData = array();
                //==========shipping data============//
                if(empty($this->input->post('ship_add_checkbox'))){

                    $shiprules = array(
                        array(
                                'field' => 'sh_address',
                                'label' => 'Address ',
                                'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                                'field' => 'sh_city',
                                'label' => 'City',
                                'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                                'field' => 'sh_state',
                                'label' => 'State',
                                'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                                'field' => 'sh_postcode',
                                'label' => 'Post Code',
                                'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                                'field' => 'sh_country',
                                'label' => 'Country',
                                'rules' => 'required|trim|xss_clean'
                        ),
                    );
                    
                    $this->form_validation->set_rules($shiprules);

                    if($this->form_validation->run()){

                        $shipData['shipping_address']= $this->input->post('sh_address');
                        $shipData['shipping_alt_add']= $this->input->post('alt_shaddress');
                        $shipData['shipping_city']= $this->input->post('sh_city');
                        $shipData['shipping_state']= $this->input->post('sh_state');
                        $shipData['shipping_country']= $this->input->post('sh_country');
                        $shipData['shipping_postalcode']= $this->input->post('sh_postcode');
                        $shipData['shipping_createdate'] = $createddate;

                    }else{
                        $return = array('success'=>false,'msg'=>validation_errors());
                        echo json_encode($return); exit;
                    }
                }

                $lic_ia_ofconsumer = $this->generalmodel->lic_ia_ofconsumer($createdby);

                //==============product data and calculating amount==========//

                $amount = $discount = $total_amt = $lic_disburse = $ia_disburse = $eta_disburse= 0;
                $auditArr = array();

                $tables[0]['table'] = 'cart';
                $tables[0]['on']    = 'product.prod_id=cart.prod_id';
                $tables[1]['table'] = 'product_category';
                $tables[1]['on']    = 'product_category.prod_cat_id=product.prod_cat_id';
                $products = $this->generalmodel->getfrommultipletables("product.*, cart.*,product_category.prod_cat_name",'product', $tables,array('prod_status'=>'1','cart.createdby'=>$this->userdata['user_id']),"","","","","result_array");

                if(!empty($products)){ $i=0; foreach($products as $prod){

                    $prodData[$i]['prod_dis'] = 0;
					$prodData[$i]['dis_percent'] = 0;
                    $prod_total=0;
                    $prod_total = round((floatval($prod['c_price'])*floatval($prod['prod_qty'])),2);
                    $amount += $prod_total;
                    if(!empty($prod['prod_dis'])){
                        $disc_start = strtotime($prod['prod_dis_startdate']);
                        $disc_end = strtotime($prod['prod_dis_enddate']);
                        if(strtotime($createddate) >=$disc_start && strtotime($createddate)<=$disc_end){
                            $prod_dis = round(((floatval($prod_total)*floatval($prod['prod_dis']))/100),2);
							$dis_percent = $prod['prod_dis'];
                            $discount += $prod_dis;
                            $prodData[$i]['prod_dis'] = $prod_dis;
							$prodData[$i]['dis_percent'] = $dis_percent;
                        }
                    }

                    $prodData[$i]['prod_id'] = $prod['prod_id'];
                    $prodData[$i]['consumer_id'] = $createdby;
                    $prodData[$i]['supplier_id'] = $prod['supplier_id'];
                    $prodData[$i]['ia_id']       = $lic_ia_ofconsumer['ia_userid'];
                    $prodData[$i]['lic_id']      = $lic_ia_ofconsumer['lic_userid'];


                    $prodData[$i]['prod_name'] = $prod['product_name'];
                    $prodData[$i]['prod_price'] = $prod['c_price'];
                    $prodData[$i]['prod_qty'] = $prod['prod_qty'];
                    $prodData[$i]['prod_total'] = $prod_total;
                    $prodData[$i]['createdate'] = $createddate;

                    if($prod['type']=='Audit'){
                        $auditArr[$i]['prod_id'] = $prod['prod_id'];
                        $auditArr[$i]['prod_name'] = $prod['product_name'];
                        $auditArr[$i]['createdate'] = date('Y-m-d h:i:s');
                        $auditArr[$i]['status'] = '0';
                        $auditArr[$i]['businessname'] = $this->input->post('au_business');
                    }

                    //====disburse calculation
                    $eta_prod_disburse = ($prod['l_price']-$prod['wsale_price'])*floatval($prod['prod_qty']);
                    $lic_prod_disburse = ($prod['ia_price']-$prod['l_price'])*floatval($prod['prod_qty']); 
                    $ia_prod_disburse = (($prod['c_price']-$prod['ia_price'])*floatval($prod['prod_qty']))-$discount;

                    $lic_disburse += $lic_prod_disburse;
                    $ia_disburse  += $ia_prod_disburse;
                    $eta_disburse += $eta_prod_disburse;
                    
                    $prodData[$i]['eta_disburse']= $eta_prod_disburse;
                    $prodData[$i]['ia_disburse'] = $ia_prod_disburse;
                    $prodData[$i]['lic_disburse']= $lic_prod_disburse;                    

                    $i++;
                }}
                
                $total_amt = round((floatval($amount)-floatval($discount)),2);

                //==========order data============//
                
                $orderData['lic_id'] = $lic_ia_ofconsumer['lic_userid'];
                $orderData['ia_id'] = $lic_ia_ofconsumer['ia_userid'];

                $orderData['order_status'] = '';
                $orderData['order_amt'] = $amount; 
                $orderData['order_dis'] = $discount;
                $orderData['total_amt'] = $total_amt;
                $orderData['createdate'] = $createddate;
                $orderData['createdby'] = $createdby;
                $orderData['lic_disburse'] = $lic_disburse;
                $orderData['eta_disburse'] = $eta_disburse;
                $orderData['ia_disburse'] = $ia_disburse;
                                
                if(!empty($this->input->post('ship_add_checkbox'))){
                    $orderData['is_billing_same'] = '1';
                }else{
                    $orderData['is_billing_same'] = '0';
                }

                $stripeToken = $this->input->post('stripeToken');
                $amt = $total_amt*100;
                $description = "order from  ETA";
                $stripe_return  = $this->payment($amt,$stripeToken,$description);

                if($stripe_return['status']=='succeeded'){


                    //=========additional form =======
                    $add_fields= array();
                    $basic_fields= array('fname','lname','email','address','city','state','postcode','country','ship_add_checkbox',
                        'sh_address','sh_city','sh_state','sh_postcode','sh_country','add_info','card_number','month','year','cvc','stripeToken','au_business','alt_address','alt_shaddress');
                    $k=1;
                    foreach ($_POST as $key => $value) {
                       if(!in_array($key,$basic_fields) && strpos($key, '_label')== false){
                        $field_name = $_POST[$key.'_label'];
                        $add_fields[$k][$field_name] = $value;
                        $k++;
                       }
                    }


                    if(!empty($_FILES)){
						$f=0;
                        foreach($_FILES as $key=>$value){
                            $fname = $_FILES[$key]['name'];
                            $fileData = $this->uploadDoc($key,'./uploads/additional_fields',array('jpg','jpeg','png','pdf'));
                            
                            if(empty($fileData['error'])){

                                $field_name = $_POST[$key.'_label'];

                                $file_name = $fileData['file_name'];
                                $add_fields['files'][$f][$field_name] = $file_name;
                            }else{
                                $return = array('success'=>false,'msg'=>$fileData['error']);
                                echo json_encode($return); exit;
                            }
							$f++;
                        }
                    }

                        //echo "<pre>"; print_r($add_fields); exit;
 
                    $orderData['add_fields'] = empty($add_fields)?'':serialize($add_fields);


                    //=========additional form =======  

                    $card_brand = $stripe_return['payment_method_details']['card']['brand'];
                    $lastfour = $stripe_return['payment_method_details']['card']['last4'];
                    $expiry_month = $stripe_return['payment_method_details']['card']['exp_month'];
                    $expiry_year = $stripe_return['payment_method_details']['card']['exp_year'];
                    $transactionid = $stripe_return['id'];

                    //============payment data============//
                    //$payData['pay_mode'] = $this->input->post('pay_mode');
                    $payData['pay_mode'] = 'Credit Card';
                    $payData['pay_createdate'] = $createddate;
                    $payData['pay_status'] = '';
                    $payData['pay_createdby'] = $createdby;
                    $payData['pay_transactionid'] = $transactionid;
                    $payData['card_brand'] = $card_brand;
                    $payData['lastfour'] = $lastfour;
                    $payData['expiry_month'] = $expiry_month;
                    $payData['expiry_year'] = $expiry_year;

                    $order_id = $this->shop_model->add_order($billingData,$shipData,$payData,$orderData,$prodData,$createdby,$auditArr);
                   


                    if(!empty($order_id)){
                        $this->session->unset_userdata('cartvalue');  
                        $return = array('success'=>true,'msg'=>'Order Placed successfully','order_id'=>$order_id);
                    }else{
                        $return = array('success'=>false,'msg'=>'something went wrong');
                    }
                }else{
                    $return = array('success'=>false,'msg'=>$stripe_return['msg']);
                }

            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;   
        }else{

            $tables[0]['table'] = 'cart';
            $tables[0]['on']    = 'product.prod_id=cart.prod_id';
            $where = "`prod_status`='1' AND `cart.createdby`=".$this->userdata['user_id'];
            $data['products'] = $this->generalmodel->getfrommultipletables("product.*, cart.*",'product', $tables,$where,"","","","","result_array");
            
            if(empty($data['products'])){
                redirect('/shop');
            }else{
                $ck_form_id = array();
                foreach($data['products'] as $prod){

                    if(!empty($prod['ck_form_id'])){ $ck_form_id[] = $prod['ck_form_id']; }
                }
                if(!empty($ck_form_id)){
                    $ids = implode(',',$ck_form_id);
                    $data['add_ques'] = $this->generalmodel->getparticularData('form_manager.frm_manager_fields','form_manager',"`frm_manager_id` IN(".$ids.") AND frm_status='1'",'result_array');
                }
            }
            $data['countrylist'] = $this->generalmodel->countrylist();
            $this->load->view('shop/checkoutpage',$data);          
        }
    }

    public function payment($amount,$token,$description)
    {   
        require_once('application/libraries/stripe-php/init.php');
        
        try{

            \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
            

            $charge = \Stripe\Charge::create ([
            "amount" => $amount,
            "currency" => "usd",
            "source" =>$token,
            "description" => $description 
            ]);
            $chargeJson = $charge->jsonSerialize();


            return  $chargeJson;
        } catch (\Stripe\Exception\RateLimitException $e) {
          // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
          // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
          // Authentication with Stripe's API failed
          // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
          // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
        }   

        return array('status'=>'fail','msg'=>$e->getError()->message);
        //print_r($e->getError()->message); exit;
    }

    public function order_summary($oid){
        $data['order_detail'] = $this->shop_model->order_summary($oid);
        $this->load->view('shop/order_summary',$data);
    }

    public function download_order_summary($oid){
        include APPPATH . 'third_party/mpdf-development/GeneratePdf.php';
        $data['order_detail'] = $this->shop_model->order_summary($oid);
        $html = $this->load->view('shop/order_summary_pdf',$data,true); 
        $filename = "order-summary".$oid.".pdf" ; 
        GeneratePdf::download($html,$filename);
    }

    public function expressInt(){

        if($this->input->is_ajax_request() && !empty($_POST)){
            
            if($this->form_validation->run('expressInt')){
                
                $id= $this->input->post('pid');
                $product = $this->shop_model->getproductDetail($id);
                if(!empty($product)){

                    // $already_exist = $this->generalmodel->getparticularData("cart_id,prod_id",'cart',array('prod_id'=>$id,'createdby'=>$this->userdata['user_id']),"row_array");

                    // if(empty($already_exist)){
                        $ialic = $this->generalmodel->lic_ia_ofconsumer($this->userdata['user_id']);
                        
                        $createdate = date('Y-m-d h:i:s');
                        $data['prod_id'] = $id;
                        $data['customer_id'] = $this->userdata['user_id'];
                        $data['ia_id'] = $ialic['ia_userid'];
                        $data['lic_id'] = $ialic['lic_userid'];
                        $data['createdate'] = $createdate;
                        $data['exp_createdby'] = 4;
                        $this->generalmodel->add('interest_expression', $data);
                        

                        $return = array('success'=>true,'msg'=>'Your Interest has been expressed successfully');
                        
                        $ia_email = $ialic['ia_email'];
                        //========send mail to ia
                        
                        $sendername = 'ETA';
                        $mailData = $this->generalmodel->mail_template('email_subject,email_body','int_expression_to_ia');

                        $content = $mailData['email_body'];
                        // $content = str_replace('[name]',$username,$mailData);
                        // $content = str_replace('[courseName]',$courseName,$mailData);

                        

                        $message = $this->load->view('include/mail_template',array('content'=>$content),true);
                        
                        $subject = $mailData['email_subject'];
                        $mailresponce = $this->sendGridMail('',$ia_email,$subject,$message);


                        // if(empty($product['ia_price'])){
                        //     $lic_email = $ialic['lic_email'];
                        //     //send mail to li
                        // }                    
                    //}else{
                    //     $return = array('success'=>true,'msg'=>'Product is already exist in your cart');
                    // }    
                }              
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }

        }else{
            $return = array('success'=>false,'msg'=>'post empty');
        }
        echo json_encode($return); exit;
    
    }

  

}