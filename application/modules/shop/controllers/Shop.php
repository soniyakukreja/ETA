<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \angelleye\PayPal\rest\checkout_orders\CheckoutOrdersAPI;


use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

require_once APPPATH. 'third_party/paypal/vendor/autoload.php';

class Shop extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
        
        if($this->userdata['urole_id']!=4){
            redirect('/');
        }
        $this->load->model("Shop/shop_model");
        $this->localtimzone =$this->userdata['timezone'];
    }
    
    public function index()
    {

        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");
        $data['meta_title'] = 'Shop';
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

        //$data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");

        
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
        $id = decoding($pid);
        $tables[0]['table'] = 'cart';
        $tables[0]['on']    = 'product.prod_id=cart.prod_id';
        $data['product'] = $this->generalmodel->getfrommultipletables("cart.*,product.*",'product', $tables,array('prod_status'=>'1','product.prod_id'=>$id,'cart.createdby'=>$this->userdata['user_id']),"","","","","row_array");
        $data['prod_cat'] = $this->generalmodel->getparticularData("*",'product_category',array('prod_cat_parent_category_id'=>'0','prod_cat_status'=>'1'),"result_array","","","prod_cat_name");
        $data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");
        
        $data['meta_title'] = 'Product Detail';
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

                        if($qty>0){
                            $query = $this->generalmodel->updaterecord('cart', $data,$where);
                        }else{
                            $query = $this->generalmodel->deleterecord('cart',$where);

                        }
                    }  

                    $cartData = $this->generalmodel->user_cartData($this->userdata['user_id']);
                    $this->session->set_userdata('cartvalue',$cartData['pricetotal']);
                    $this->session->set_userdata('cartqty',$cartData['qtytotal']);  
                    
                    $return = array('success'=>true,'msg'=>'Cart updated successfully!','qtytotal'=>$cartData['qtytotal']);


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
                //$data['usercart'] = $this->shop_model->getparticularData('GROUP_CONCAT(prod_id SEPARATOR ",") AS ids','cart',array('createdby'=>$this->userdata['user_id']),"row_array");
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

                    $already_exist = $this->generalmodel->getparticularData("cart_id,prod_id,prod_qty",'cart',array('prod_id'=>$id,'createdby'=>$this->userdata['user_id']),"row_array");

                    $createdate = date('Y-m-d h:i:s');

                    $data['createdby'] = $this->userdata['user_id'];
                    $data['createdate'] = $createdate;
                    $data['prod_cat_id'] = $product['prod_cat_id']; 
                    $data['prod_price'] = $product['c_price'];
                    
                    $dicount = $product['prod_dis'];
                    if(!empty($product['prod_dis'])){
                        $disc_start = strtotime($product['prod_dis_startdate']);
                        $disc_end = strtotime($product['prod_dis_enddate']);
                        if(strtotime($createdate) <=$disc_start && strtotime($createdate)>=$disc_end){
                            $dicount = 0;
                        }
                    }                    
                    $data['prod_dis'] = $dicount;

                    if(empty($already_exist)){
                        $qty = empty($this->input->post('qty'))?1:$this->input->post('qty');
                        $data['prod_id'] = $id;
                        $data['prod_qty'] = round($qty,2);
                        $query = $this->generalmodel->add('cart', $data);
                    }else{
                        $qty = floatval($already_exist['prod_qty'])+1;
                        $data['prod_qty'] = round($qty,2);
                        $query = $this->generalmodel->updaterecord('cart',$data,array('cart_id'=>$already_exist['cart_id'],'prod_id'=>$already_exist['prod_id']));
                    }   

                    if($query>0){

                        $cartData = $this->generalmodel->user_cartData($this->userdata['user_id']);
                        $this->session->set_userdata('cartvalue',$cartData['pricetotal']);
                        $this->session->set_userdata('cartqty',$cartData['qtytotal']);  

                        $return = array('success'=>true,'msg'=>'Product added to  your cart successfully','qtytotal'=>$cartData['qtytotal']);
                    }else{
                        $return = array('success'=>false,'msg'=>'Something went wrong');
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
        $data['meta_title'] = 'Cart';
        
        $this->load->view('shop/your_cart',$data);  
    }

    public function remove_fromcart(){
        if($this->input->is_ajax_request() && !empty($_POST)){
            $cartid = $this->input->post('cartid');
            $query = $this->generalmodel->deleterecord('cart',array('cart_id'=>$cartid,'createdby'=>$this->userdata['user_id']));
            
            //====reset cart in session=====
            $cartData = $this->generalmodel->user_cartData($this->userdata['user_id']);
            $this->session->set_userdata('cartvalue',$cartData['pricetotal']);
            $this->session->set_userdata('cartqty',$cartData['qtytotal']); 

            $return = array('success'=>true,'msg'=>'Product removed from cart!','qtytotal'=>$cartData['qtytotal']);
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


    public function checkout_stripe(){

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
            $data['meta_title'] = 'Checkout';

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
        $oid = decoding($oid);
        $data['order_detail'] = $this->shop_model->order_summary($oid);
        $data['meta_title'] = 'Order Summary';
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


    public function au_test(){
         $this->load->library('paypal_lib'); 
        $domain = 'http://45.33.105.92/ETA/';
        $rest_client_id = 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta';
        $rest_client_secret = "ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D";
        $configArray = array(
            'Sandbox' => TRUE,
            'ClientID' => $rest_client_id,
            'ClientSecret' => $rest_client_secret,
            'LogResults' => false,
            'LogPath' =>  $_SERVER['DOCUMENT_ROOT'].'/ETA/logs/',
            'LogLevel' => 'DEBUG'
        );

        $PayPal = new CheckoutOrdersAPI($configArray);



        $intent = 'CAPTURE';            // Required

        $currency = 'USD';              // The three-character ISO-4217 currency code that identifies the currency. https://developer.paypal.com/docs/integration/direct/rest/currency-codes/


        $items[0] = array(
            'sku'         => '123',                                    // Stock keeping unit corresponding (SKU) to item.Maximum length: 127.
            'name'        => 'Hat',                                    // Required if you are adding item array. The item name or title. 127 characters max.
            'description' => 'Kansas City Chiefs Large Multi-Fit Hat', // The detailed item description. Maximum length: 127.
            'quantity'    => 1,                                        // The item quantity. Must be a whole number. Maximum length: 10.
            'unit_amount' => array(
                'value' => 7.50,
                'currency_code' => $currency
            ),                                     // Required if you are adding item array. The item price or rate per unit. 32 characters max.
            'tax'         => array(
                'value' => 0.00,
                'currency_code' => $currency
            ),                                     // The item tax for each unit.
            'category'    => 'PHYSICAL_GOODS'                          // The item category type. DIGITAL_GOODS | PHYSICAL_GOODS
        );

        $items[1] = array(
            'sku'         => '678',                                 // Stock keeping unit corresponding (SKU) to item.Maximum length: 127.
            'name'        => 'Handbag',                             // Required if you are adding item array. The item name or title. 127 characters max.
            'description' => 'Small, leather handbag.',             // The detailed item description. Maximum length: 127.
            'quantity'    => 2,                                     // The item quantity. Must be a whole number. Maximum length: 10.
            'unit_amount' => array(
                'value' => 5.00,
                'currency_code' => $currency
            ),                                  // Required if you are adding item array. The item price or rate per unit. 32 characters max.
            'tax'         => array(
                'value' => 0.00,
                'currency_code' => $currency
            ),                                  // The item tax for each unit.
            'category'    => 'PHYSICAL_GOODS'                       // The item category type. DIGITAL_GOODS | PHYSICAL_GOODS
        );

        $orderItems = $items;
        $orderAmt = 17.50;
        $amount = array(
            'currency_code' => $currency,
            'value' => $orderAmt,
            'breakdown' => array(
                'item_total' => array(          // The subtotal for all items.
                    'value' => $orderAmt,
                    'currency_code' => $currency
                ),
                'shipping' => array(            // The shipping fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'handling' => array(            // The handling fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'tax_total' => array(            // The total tax for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'insurance' => array(            // The insurance fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'shipping_discount' => array(    // The shipping discount for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                )
            )
        );

        

        $application_context = array(
            'brand_name' => 'AngellEye INC',              // The label that overrides the business name in the PayPal account on the PayPal site.
            'locale' => 'en-US',                          // PayPal supports a five-character code.
            'landing_page' => 'BILLING',                    // Allowed Values : LOGIN,BILLING
            'shipping_preferences' => 'SET_PROVIDED_ADDRESS',    // Allowed Values : GET_FROM_FILE , NO_SHIPPING , SET_PROVIDED_ADDRESS
            'user_action' => 'CONTINUE',                  // Configures a Continue or Pay Now checkout flow.
            'payment_method' => array(
                'payer_selected' => 'PAYPAL',                   // Values : PAYPAL,PAYPAL_CREDIT. The customer and merchant payment preferences.
                'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'             // Values : UNRESTRICTED , IMMEDIATE_PAYMENT_REQUIRED
            ),
            'return_url' => $domain.'shop/success',  // The URL where the customer is redirected after the customer approves the payment.
            'cancel_url' => $domain.'shop/cancel', // The URL where the customer is redirected after the customer cancels the payment.

        );

        //=== Uncomment if you have shipping_preferences as SET_PROVIDED_ADDRESS in application context.===//
        $shipping = array(
                        'method' => 'United States Postal Service',
                        'name' => array(
                            'full_name' => 'Test Buyer', // When the party is a person, the party's full name.
                        ),
                        'address' => array(
                            'address_line_1' => '167, Keshar Bagh Rd',
                            'address_line_2' => 'Sachidanand Nagar',
                            'admin_area_2' => 'Madhya pradesh',     // A city, town, or village.
                            'admin_area_1' => 'India',                // country
                            'postal_code' => '452009',              // The postal code, which is the zip code or equivalent
                            'country_code' => 'IN',                // The country code.
                        ),
                    );
        //========//

        //=== Payer object is optional , if you have buyer details and you want to pass it then you can uncomment the code and use $payer in request ===//
         
        $payer = array(             // The customer who approves and pays for the order. The customer is also known as the payer.
            'email_address' => 'test_buyer@domain.com', // The email address of the payer.
            'name' => array(
                //'full_name' => 'Test Buyer', // When the party is a person, the party's full name.
                // 'prefix' => '',              // The prefix, or title, to the party's name.
                 'given_name' => 'test',          // When the party is a person, the party's given, or first, name.
                'surname' => 'buyer',             // When the party is a person, the party's surname or family name.
                // 'middle_name' => '',         // When the party is a person, the party's middle name.
                // 'suffix' => ''               // The suffix for the party's name.
            ),
            // 'phone' => array(                // The phone number of the customer. Available only when you enable the Contact Telephone Number option in the Profile & Settings for the merchant's PayPal account.
            //     'phone_type' => 'MOBILE',          // The phone type. FAX, HOME, MOBILE, OTHER, PAGER.
            //     'phone_number' => array(
            //         'national_number' => '+22 607 123 4567', // The phone number, in its canonical international E.164 numbering plan format. Supports only the national_number property.
            //     )
            // ),
            //'birth_date' => '',              // The birth date of the payer in YYYY-MM-DD format.
            'address' => array(
                'address_line_1' => '167, Keshar Bagh Rd',
                'address_line_2' => 'Sachidanand Nagar',
                'admin_area_2' => 'Indore',     // A city, town, or village.
                'admin_area_1' => 'Madhya pradesh',                // country
                'postal_code' => '452009',              // The postal code, which is the zip code or equivalent
                'country_code' => 'IN',                // The country code.
            )
        );
        //=========//

        $purchase_units  = array(
            'reference_id' => 'default',                  // The ID for the purchase unit. Required for multiple purchase_units or if an order must be updated by using PATCH. If you omit the reference_id for an order with one purchase unit, PayPal sets the reference_id to default.
            'description' => 'Sporting Goods',            // The purchase description. Maximum length: 127.
            'custom_id' => 'CUST-PayPalFashions',         // The API caller-provided external ID. Used to reconcile client transactions with PayPal transactions. Appears in transaction and settlement reports but is not visible to the payer.
            'soft_descriptor' => 'PayPalFashions',        // The payment descriptor on the payer's credit card statement. Maximum length: 22.
            'invoice_id' => 'AEINV-'.rand(0,1000),        // The API caller-provided external invoice number for this order. Appears in both the payer's transaction history and the emails that the payer receives. Maximum length: 127.
            'amount' => $amount,
            'shipping' => $shipping,                        // Add $shipping if you have shipping_preferences as SET_PROVIDED_ADDRESS in application context.
            'items' => $orderItems
        );

        $requestArray = array(
            'intent'=>$intent,
            'application_context' => $application_context,
            'purchase_units' => $purchase_units,
            'payer' => $payer
        );




        $response = $PayPal->CreateOrder($requestArray);

        if($response['RESULT']=='Success'){
            $re = $response['APPROVAL_LINK'];
            redirect($re);
        }
        echo "<pre>";
        print_r($response);exit;
        echo "<pre>"; print_r($items);
        echo "<pre>"; print_r($orderAmt);
        echo "<pre>"; print_r($shipping);
        echo "<pre>"; print_r($payer);
        exit;

    }

    public function test(){
         $this->load->library('paypal_lib'); 
        $domain = 'http://45.33.105.92/ETA/';
        $rest_client_id = 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta';
        $rest_client_secret = "ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D";
        $configArray = array(
            'Sandbox' => TRUE,
            'ClientID' => $rest_client_id,
            'ClientSecret' => $rest_client_secret,
            'LogResults' => false,
            'LogPath' =>  $_SERVER['DOCUMENT_ROOT'].'/ETA/logs/',
            'LogLevel' => 'DEBUG'
        );

        $PayPal = new CheckoutOrdersAPI($configArray);



        $intent = 'CAPTURE';            // Required

        $currency = 'USD';              // The three-character ISO-4217 currency code that identifies the currency. https://developer.paypal.com/docs/integration/direct/rest/currency-codes/


        $items[0] = array(
            'sku'         => '123',                                    // Stock keeping unit corresponding (SKU) to item.Maximum length: 127.
            'name'        => 'Hat',                                    // Required if you are adding item array. The item name or title. 127 characters max.
            'description' => 'Kansas City Chiefs Large Multi-Fit Hat', // The detailed item description. Maximum length: 127.
            'quantity'    => 1,                                        // The item quantity. Must be a whole number. Maximum length: 10.
            'unit_amount' => array(
                'value' => 7.50,
                'currency_code' => $currency
            ),                                     // Required if you are adding item array. The item price or rate per unit. 32 characters max.
            'tax'         => array(
                'value' => 0.00,
                'currency_code' => $currency
            ),                                     // The item tax for each unit.
            'category'    => 'PHYSICAL_GOODS'                          // The item category type. DIGITAL_GOODS | PHYSICAL_GOODS
        );

        $items[1] = array(
            'sku'         => '678',                                 // Stock keeping unit corresponding (SKU) to item.Maximum length: 127.
            'name'        => 'Handbag',                             // Required if you are adding item array. The item name or title. 127 characters max.
            'description' => 'Small, leather handbag.',             // The detailed item description. Maximum length: 127.
            'quantity'    => 2,                                     // The item quantity. Must be a whole number. Maximum length: 10.
            'unit_amount' => array(
                'value' => 5.00,
                'currency_code' => $currency
            ),                                  // Required if you are adding item array. The item price or rate per unit. 32 characters max.
            'tax'         => array(
                'value' => 0.00,
                'currency_code' => $currency
            ),                                  // The item tax for each unit.
            'category'    => 'PHYSICAL_GOODS'                       // The item category type. DIGITAL_GOODS | PHYSICAL_GOODS
        );

        $orderItems = $items;
        $orderAmt = 17.50;
        $amount = array(
            'currency_code' => $currency,
            'value' => $orderAmt,
            'breakdown' => array(
                'item_total' => array(          // The subtotal for all items.
                    'value' => $orderAmt,
                    'currency_code' => $currency
                ),
                'shipping' => array(            // The shipping fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'handling' => array(            // The handling fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'tax_total' => array(            // The total tax for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'insurance' => array(            // The insurance fee for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                ),
                'shipping_discount' => array(    // The shipping discount for all items.
                    'value' => 0.00,
                    'currency_code' => $currency
                )
            )
        );

        /**
         * For shipping_preferences
         * The possible values are:
         *   GET_FROM_FILE  -  Use the customer-provided shipping address on the PayPal site.
         *   NO_SHIPPING -  Redact the shipping address from the PayPal site. Recommended for digital goods.
         *   SET_PROVIDED_ADDRESS - Use the merchant-provided address. The customer cannot change this address on the PayPal site.
         *
         *   note : if you select SET_PROVIDED_ADDRESS then you should pass $shipping array that we have in sample as commented code
         *
         */

        /**
         * For landing_page , The type of landing page to show on the PayPal site for customer checkout.
         * The possible values are :
         *       LOGIN -   Default. When the customer clicks PayPal Checkout, the customer is redirected to a page to log in to PayPal and approve the payment.
         *       BILLING - When the customer clicks PayPal Checkout, the customer is redirected to a page to enter credit or debit card and other relevant billing information required to complete the purchase.
         */

        /**
         *  For user_action, Configures a Continue or Pay Now checkout flow.
         *  CONTINUE -  After you redirect the customer to the PayPal payment page, a Continue button appears. Use this option when the final amount is not known when the checkout flow is initiated and you want to redirect the customer to the merchant page without processing the payment.
         *  PAY_NOW - After you redirect the customer to the PayPal payment page, a Pay Now button appears. Use this option when the final amount is known when the checkout is initiated and you want to process the payment immediately when the customer clicks Pay Now.
         */

        $application_context = array(
            'brand_name' => 'AngellEye INC',              // The label that overrides the business name in the PayPal account on the PayPal site.
            'locale' => 'en-US',                          // PayPal supports a five-character code.
            'landing_page' => 'BILLING',                    // Allowed Values : LOGIN,BILLING
            'shipping_preferences' => 'SET_PROVIDED_ADDRESS',    // Allowed Values : GET_FROM_FILE , NO_SHIPPING , SET_PROVIDED_ADDRESS
            'user_action' => 'CONTINUE',                  // Configures a Continue or Pay Now checkout flow.
            'payment_method' => array(
                'payer_selected' => 'PAYPAL',                   // Values : PAYPAL,PAYPAL_CREDIT. The customer and merchant payment preferences.
                'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'             // Values : UNRESTRICTED , IMMEDIATE_PAYMENT_REQUIRED
            ),
            // 'return_url' => $domain.'samples/rest/checkout_orders/CaptureOrder.php?success=true',  // The URL where the customer is redirected after the customer approves the payment.
            // 'cancel_url' => $domain.'samples/rest/checkout_orders/CaptureOrder.php?success=false', // The URL where the customer is redirected after the customer cancels the payment.
            'return_url' => $domain.'shop/success',  // The URL where the customer is redirected after the customer approves the payment.
            'cancel_url' => $domain.'shop/cancel', // The URL where the customer is redirected after the customer cancels the payment.

        );

        //=== Uncomment if you have shipping_preferences as SET_PROVIDED_ADDRESS in application context.===//
        $shipping = array(
                        'method' => 'United States Postal Service',
                        'name' => array(
                            'full_name' => 'Test Buyer', // When the party is a person, the party's full name.
                            // 'prefix' => '',              // The prefix, or title, to the party's name.
                            // 'given_name' => '',          // When the party is a person, the party's given, or first, name.
                            // 'surname' => '',             // When the party is a person, the party's surname or family name.
                            // 'middle_name' => '',         // When the party is a person, the party's middle name.
                            // 'suffix' => ''               // The suffix for the party's name.
                        ),
                        'address' => array(
                            'address_line_1' => '123 Townsend St',
                            'address_line_2' => 'Floor 6',
                            'admin_area_2' => 'San Francisco',     // A city, town, or village.
                            'admin_area_1' => 'CA',                // country
                            'postal_code' => '94107',              // The postal code, which is the zip code or equivalent
                            'country_code' => 'US',                // The country code.
                        ),
                    );
        //========//

        //=== Payer object is optional , if you have buyer details and you want to pass it then you can uncomment the code and use $payer in request ===//
         
        $payer = array(             // The customer who approves and pays for the order. The customer is also known as the payer.
            'email_address' => 'test_buyer@domain.com', // The email address of the payer.
            'name' => array(
                //'full_name' => 'Test Buyer', // When the party is a person, the party's full name.
                // 'prefix' => '',              // The prefix, or title, to the party's name.
                 'given_name' => 'test',          // When the party is a person, the party's given, or first, name.
                'surname' => 'buyer',             // When the party is a person, the party's surname or family name.
                // 'middle_name' => '',         // When the party is a person, the party's middle name.
                // 'suffix' => ''               // The suffix for the party's name.
            ),
            // 'phone' => array(                // The phone number of the customer. Available only when you enable the Contact Telephone Number option in the Profile & Settings for the merchant's PayPal account.
            //     'phone_type' => 'MOBILE',          // The phone type. FAX, HOME, MOBILE, OTHER, PAGER.
            //     'phone_number' => array(
            //         'national_number' => '+22 607 123 4567', // The phone number, in its canonical international E.164 numbering plan format. Supports only the national_number property.
            //     )
            // ),
            //'birth_date' => '',              // The birth date of the payer in YYYY-MM-DD format.
            'address' => array(
                'address_line_1' => '123 Townsend St',
                'address_line_2' => 'Floor 6',
                'admin_area_2' => 'San Francisco',     // A city, town, or village.
                'admin_area_1' => 'CA',                // country
                'postal_code' => '94107',              // The postal code, which is the zip code or equivalent
                'country_code' => 'US',                // The country code.
            )
        );
        //=========//

        $purchase_units  = array(
            'reference_id' => 'default',                  // The ID for the purchase unit. Required for multiple purchase_units or if an order must be updated by using PATCH. If you omit the reference_id for an order with one purchase unit, PayPal sets the reference_id to default.
            'description' => 'Sporting Goods',            // The purchase description. Maximum length: 127.
            'custom_id' => 'CUST-PayPalFashions',         // The API caller-provided external ID. Used to reconcile client transactions with PayPal transactions. Appears in transaction and settlement reports but is not visible to the payer.
            'soft_descriptor' => 'PayPalFashions',        // The payment descriptor on the payer's credit card statement. Maximum length: 22.
            'invoice_id' => 'AEINV-'.rand(0,1000),        // The API caller-provided external invoice number for this order. Appears in both the payer's transaction history and the emails that the payer receives. Maximum length: 127.
            'amount' => $amount,
            'shipping' => $shipping,                        // Add $shipping if you have shipping_preferences as SET_PROVIDED_ADDRESS in application context.
            'items' => $orderItems
        );

        $requestArray = array(
            'intent'=>$intent,
            'application_context' => $application_context,
            'purchase_units' => $purchase_units,
            'payer' => $payer
        );




        $response = $PayPal->CreateOrder($requestArray);

        if($response['RESULT']=='Success'){
            $re = $response['APPROVAL_LINK'];
            redirect($re);
        }
        echo "<pre>";
        print_r($response);exit;
        echo "<pre>"; print_r($items);
        echo "<pre>"; print_r($orderAmt);
        echo "<pre>"; print_r($shipping);
        echo "<pre>"; print_r($payer);
        exit;

    }
    

    //public function checkout_paypal(){
    public function checkout(){
        if($this->input->is_ajax_request() && !empty($_POST)){
			$discount=0;
            if($this->form_validation->run('add_order')){
                
                $this->session->unset_userdata('order_capture_id');

                $shipping = array();
                $currency = 'USD'; 
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


                //=======paypal billing detail===//
                $bl_countryData = getcountry_data($this->input->post('country'));

                $payer = array(             // The customer who approves and pays for the order. The customer is also known as the payer.
                    'email_address' => $billingData['billing_email'], // The email address of the payer.
                    'name' => array(
                        'given_name' => $billingData['billing_fname'],          // When the party is a person, the party's given, or first, name.
                        'surname' => $billingData['billing_lname'],             // When the party is a person, the party's surname or family name.
                    ),
                     'address' => array(
                        'address_line_1' => $billingData['billing_address'],
                        'address_line_2' => $billingData['billing_alt_add'],
                        'admin_area_2' => $billingData['billing_city'],     // A city, town, or village.
                        'admin_area_1' => $billingData['billing_state'],                // country
                        'postal_code' => $billingData['billing_postalcode'],              // The postal code, which is the zip code or equivalent
                        'country_code' => $bl_countryData['country_codes'],                // The country code.
                    )
                );

                $shipping = array(  
                    'method' => 'United States Postal Service',
                    'name' => array(
                        'full_name' => $billingData['billing_fname'].' '.$billingData['billing_lname'], // When the party is a person, the party's full name.
                     ),
                    'address' => array(
                        'address_line_1' => $billingData['billing_address'],
                        'address_line_2' => $billingData['billing_alt_add'],
                        'admin_area_2' => $billingData['billing_city'],     // A city, town, or village.
                        'admin_area_1' =>$billingData['billing_state'],                // country
                        'postal_code' => $billingData['billing_postalcode'],              // The postal code, which is the zip code or equivalent
                        'country_code' => $bl_countryData['country_codes'],                // The country code.
                    ),
                ); 

            //echo "<pre>"; print_r($payer);
                //=======paypal billing detail===//
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

                        $sh_countryData = getcountry_data($this->input->post('sh_country'));

                        //=======paypal shipping detail===//
                            $shipping = array(  
                                'method' => 'United States Postal Service',
                                'name' => array(
                                    'full_name' => $billingData['billing_fname'].' '.$billingData['billing_lname'], // When the party is a person, the party's full name.
                                 ),
                                'address' => array(
                                    'address_line_1' => $shipData['shipping_address'],
                                    'address_line_2' => $shipData['shipping_alt_add'],
                                    'admin_area_2' => $shipData['shipping_city'],     // A city, town, or village.
                                    'admin_area_1' => $shipData['shipping_state'],                // country
                                    'postal_code' => $shipData['shipping_postalcode'],              // The postal code, which is the zip code or equivalent
                                    'country_code' => $sh_countryData['country_codes'],                // The country code.
                                ),
                            );                      
                        //=======paypal shipping detail===//
                    }else{
                        $return = array('success'=>false,'msg'=>validation_errors());
                        echo json_encode($return); exit;
                    }
                }

            //echo "<pre>"; print_r($shipping); exit;

                $lic_ia_ofconsumer = $this->generalmodel->lic_ia_ofconsumer($createdby);

                //==============product data and calculating amount==========//

                $amount = $discount = $total_amt = $lic_disburse = $ia_disburse = $eta_disburse= 0;
                $auditArr = array();

                $tables[0]['table'] = 'cart';
                $tables[0]['on']    = 'product.prod_id=cart.prod_id';
                $products = $this->generalmodel->getfrommultipletables("product.*, cart.*",'product', $tables,array('prod_status'=>'1','cart.createdby'=>$this->userdata['user_id']),"","","","","result_array");

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
                        $auditArr[$i]['updatedate'] = date('Y-m-d h:i:s');
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

                    //=========paypal product detail=========//
                    $items[$i] = array(
                        'sku'         => substr($prod['product_sku'], 0, 100),                                   // Stock keeping unit corresponding (SKU) to item.Maximum length: 127.
                        'name'        => substr($prod['product_name'], 0, 100),                                    // Required if you are adding item array. The item name or title. 127 characters max.
                        'description' => substr($prod['prod_description'], 0, 100), // The detailed item description. Maximum length: 127.
                        'quantity'    => $prod['prod_qty'],                                        // The item quantity. Must be a whole number. Maximum length: 10.
                        'unit_amount' => array(
                            'value' => $prod['c_price'],
                            'currency_code' => $currency
                        ),                                     // Required if you are adding item array. The item price or rate per unit. 32 characters max.
                        'tax'         => array(
                            'value' => 0.00,
                            'currency_code' => $currency
                        ),                                     // The item tax for each unit.
                        'category'    => 'PHYSICAL_GOODS'                          // The item category type. DIGITAL_GOODS | PHYSICAL_GOODS
                    );
                    //=========paypal product detail=========//

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

                $orderData['add_fields'] = empty($add_fields)?'':serialize($add_fields);


                //=========additional form =======  


                //============payment data============//
                //$payData['pay_mode'] = $this->input->post('pay_mode');
                // $payData['pay_mode'] = 'Credit Card';
                // $payData['pay_createdate'] = $createddate;
                // $payData['pay_status'] = '';
                // $payData['pay_createdby'] = $createdby;
                // $payData['pay_transactionid'] = $transactionid;
                // $payData['card_brand'] = $card_brand;
                // $payData['lastfour'] = $lastfour;
                // $payData['expiry_month'] = $expiry_month;
                // $payData['expiry_year'] = $expiry_year;

                $sess_array['bData'] = $billingData;
                $sess_array['shData'] = $shipData;
                $sess_array['orderData'] = $orderData;
                $sess_array['prodData'] = $prodData;
                $sess_array['auditArr'] = $auditArr;
                //$order_id = $this->shop_model->add_order($billingData,$shipData,$payData,$orderData,$prodData,$createdby,$auditArr);
                
                $this->load->library('paypal_lib'); 
                $return  = $this->paypal_lib->create_capture_order($items,$amount,$shipping,$payer,$discount);
                if($return['RESULT']=='Success'){

                    $this->session->set_userdata('order_capture_id',$return['ORDER']['id']);
                    $this->session->set_userdata('orderDetail',serialize($sess_array));

                    $return = array('success'=>true,'redirect'=>$return['APPROVAL_LINK']);
                    echo json_encode($return); exit;
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

            $data['mydata'] = $this->generalmodel->my_profile_data();
            $data['meta_title'] = 'Checkout';
            $this->load->view('shop/checkoutpage_paypal',$data);          
        }
    }

    public function success(){  
        $this->load->library('paypal_lib'); 

        $oid = $this->session->userdata['order_capture_id'];
        $return  = $this->paypal_lib->order_detail($oid);
        $r_orderDetail = $return['ORDER']['purchase_units'][0];
 

        if($_SESSION['orderDetail']){ 
            $od = unserialize($_SESSION['orderDetail']);
            $orderData['pay_id'] =$oid;

            $createdby = $this->userdata['user_id'];
            $payData= array();
            $order_id = $this->shop_model->add_order($od['bData'],$od['shData'],$payData,$od['orderData'],$od['prodData'],$createdby,$od['auditArr']);
            if(!empty($order_id)){
                $this->session->unset_userdata('orderDetail');  
                $this->session->unset_userdata('cartvalue');  
                $this->audit_mail_to_consumer($order_id);
                $this->audit_mail_to_supplier($order_id);
                $this->order_mail_kam($order_id);
                $this->order_mail_csr($order_id);
                
                redirect('order-summary/'.encoding($order_id));
            }else{
                $return = array('success'=>false,'msg'=>'something went wrong');
            }
        }
    }
    public function cancel(){ 
        $data['meta_title'] = 'Payment Cancel';
        $this->load->view('shop/payment_canceled',$data);
    }

    public function audit_mail_to_consumer($oid){

       // echo "<pre>"; print_r($order_detail); exit;
        $only_audit = true; 
        $order_detail = $this->shop_model->order_summary($oid,$only_audit);
        $consumer_id = $order_detail['detail']['createdby'];


        $data = $this->generalmodel->getparticularData('user_id,email,firstname,lastname','user',"user_id=".$consumer_id,'row_array');

        $sendername = 'ETA';
        $to = $data['email'];

        $mailContent = $this->generalmodel->mail_template('email_subject,email_body','audit_purchased_consumer');


        $receipent_name = $data['firstname'].' '.$data['lastname'];
        $order_number = $order_detail['detail']['orders_id'];

        $odate = gmdate_to_mydate($order_detail['detail']['createdate'],$this->localtimzone);
        $order_date = date('m/d/Y',strtotime($odate));
        $order_status = 'Pending Audit';
        $order_product_detail = '';


        if(!empty($order_detail['products'])){
           $order_product_detail = '<table style="border:1px solid;border-collapse: collapse; width:100%; margin-top:20px;">
                <thead>
                    <tr><th colspan="3" style="border: 1px solid;text-align: center;">Audit Products Detail</th>
                    </tr><tr><th style="border: 1px solid;text-align: left;">Name</th><th style="border: 1px solid;text-align: right;">Quantity</th><th style="border: 1px solid;text-align: right;">Price</th>
                    </tr></thead><tbody>';
        
            foreach($order_detail['products'] as $op){

                $price = numfmt_format_currency($this->fmt,$op['prod_price'], "USD").' USD';
                $order_product_detail .= '<tr><td style="border: 1px solid">'.$op['prod_name'].'</td><td style="border: 1px solid;text-align: right;">'.$op['prod_qty'].'</td><td style="border: 1px solid;text-align: right;">'.$price.'</td></tr>';
            }
            $priceSum = array_sum(array_column($order_detail['products'], 'prod_price'));
            $totalPrice = numfmt_format_currency($this->fmt,$priceSum, "USD").' USD';
            $order_product_detail .= '<tr><td colspan="2" style="border: 1px solid;text-align: right;">Cart Total</td><td style="border: 1px solid;text-align: right;">'.$totalPrice.'</td></tr></tbody></table>';
        }
        

        $cdata = getcountry_data($order_detail['detail']['billing_country']); 

        $checkout_billing_detail = '<h4>Billing Details</h4><p style="line-height:22px;">';
        $checkout_billing_detail .= $order_detail['detail']['billing_fname'].' '.$order_detail['detail']['billing_lname'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_email'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_address'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_city'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_state'].'<br>';
        $checkout_billing_detail .= $cdata['country_name'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_postalcode'].'</p>';


        $checkout_shipping_detail = '<h4>Shipping Details</h4>';
        if($order_detail['detail']['is_billing_same']!='1'){
            $checkout_shipping_detail .= '<p style="line-height:22px;">'.$order_detail['detail']['shipping_address'].'<br>'.$order_detail['detail']['shipping_city'].'<br>'.$order_detail['detail']['shipping_state'].'</p>';
        }else{
            $checkout_shipping_detail .= '<p style="line-height:22px;">Shipping Address is same as billing address</p>';
        }

        $add_fields = unserialize($order_detail['detail']['add_fields']);
        $ck_add_q = '';
        if(!empty($add_fields)){
            $ck_add_q .= '<div style="line-height:24px;">';
            foreach($add_fields as $key=>$add){
                if($key=='files'){

                $ck_add_q .= '<table><tbody>';
                    foreach($add as $file){
                        foreach($file as $k=>$f){
                            $link = base_url('uploads/additional_fields/').$f;
                            if(!empty($f)){

                                $ck_add_q .= '<tr style="line-height:50px;" ><td>'.$k.':</td><td><a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 10px 10px;text-decoration: none;border-radius: 5px;" target="_blank" download="">Download</a></td></tr>';
                            }else{
                                $ck_add_q .= '<tr><td>'.$k.':</td><td>Not Uploaded</td></tr>';
                            }
                        }
                    }
                $ck_add_q .= '</tbody></table>';
                }else{
                    foreach($add as $k=>$v){
                        $ck_add_q .= '<b>'.$k.':</b>';
                        if(is_array($v)){ $ck_add_q .= $v[0].'<br>'; }else{ $ck_add_q .= $v.'<br>'; }
                    }
                }
            }
            $ck_add_q .= '</div>';
        }

        $content = $mailContent['email_body'];
        $content = str_replace('[name]',$receipent_name,$content);
        $content = str_replace('[order_number]',$order_number,$content); 
        $content = str_replace('[order_date]',$order_date,$content); 
        $content = str_replace('[order_status]',$order_status,$content); 
        $content = str_replace('[order_product_detail]',$order_product_detail,$content); 
        $content = str_replace('[checkout_billing_detail]',$checkout_billing_detail,$content); 
        $content = str_replace('[checkout_shipping_detail]',$checkout_shipping_detail,$content); 
        $content = str_replace('[checkout_additional_questions]',$ck_add_q,$content); 

        $message = $this->load->view('include/mail_template',array('body'=>$content),true);
        $subject = $mailContent['email_subject'];
        $subject = str_replace('[order_number]',$order_number,$subject); 
        $mailresponce = $this->sendGridMail('',$to,$subject,$message);




        //print_r($mailresponce); exit;
        //$this->load->view('include/mail_template',array('body'=>$content));
        //echo $to.'<br>'.$subject.'<br>'.$message;

    }

    public function audit_mail_to_supplier($oid){

        $only_audit = true; 
        $order_detail = $this->shop_model->order_summary($oid,$only_audit);

        $suppArr = array();
        
        if(!empty($order_detail['products'])){

            $mailContent = $this->generalmodel->mail_template('email_subject,email_body','audit_purchased_supplier');

            $consumer_id = $order_detail['detail']['createdby'];

            $consumerData = $this->db->query("SELECT b.business_name FROM user AS u JOIN business as b ON u.consumer_business_id=b.business_id WHERE u.user_id=".$consumer_id)->row_array();

            $sendername = 'ETA';            

            $order_number = $order_detail['detail']['orders_id'];

            $odate = gmdate_to_mydate($order_detail['detail']['createdate'],$this->localtimzone);
            $order_date = date('m/d/Y',strtotime($odate));
            $order_status = 'Pending Audit';

        

            $cdata = getcountry_data($order_detail['detail']['billing_country']); 

            $checkout_billing_detail = '<h4>Billing Details</h4><p style="line-height:22px;">';
            $checkout_billing_detail .= $order_detail['detail']['billing_fname'].' '.$order_detail['detail']['billing_lname'].'<br>';
            $checkout_billing_detail .= $order_detail['detail']['billing_email'].'<br>';
            $checkout_billing_detail .= $order_detail['detail']['billing_address'].'<br>';
            $checkout_billing_detail .= $order_detail['detail']['billing_city'].'<br>';
            $checkout_billing_detail .= $order_detail['detail']['billing_state'].'<br>';
            $checkout_billing_detail .= $cdata['country_name'].'<br>';
            $checkout_billing_detail .= $order_detail['detail']['billing_postalcode'].'</p>';


            $checkout_shipping_detail = '<h4>Shipping Details</h4>';
            if($order_detail['detail']['is_billing_same']!='1'){
                $checkout_shipping_detail .= '<p style="line-height:22px;">'.$order_detail['detail']['shipping_address'].'<br>'.$order_detail['detail']['shipping_city'].'<br>'.$order_detail['detail']['shipping_state'].'</p>';
            }else{
                $checkout_shipping_detail .= '<p style="line-height:22px;">Shipping Address is same as billing address</p>';
            }

            $add_fields = unserialize($order_detail['detail']['add_fields']);
            $ck_add_q = '';
            if(!empty($add_fields)){
                $ck_add_q .= '<div style="line-height:24px;">';
                foreach($add_fields as $key=>$add){
                    if($key=='files'){

                    $ck_add_q .= '<table><tbody>';
                        foreach($add as $file){
                            foreach($file as $k=>$f){
                                $link = base_url('uploads/additional_fields/').$f;
                                if(!empty($f)){

                                    $ck_add_q .= '<tr style="line-height:50px;" ><td>'.$k.':</td><td><a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 10px 10px;text-decoration: none;border-radius: 5px;" target="_blank" download="">Download</a></td></tr>';
                                }else{
                                    $ck_add_q .= '<tr><td>'.$k.':</td><td>Not Uploaded</td></tr>';
                                }
                            }
                        }
                    $ck_add_q .= '</tbody></table>';
                    }else{
                        foreach($add as $k=>$v){
                            $ck_add_q .= '<b>'.$k.':</b>';
                            if(is_array($v)){ $ck_add_q .= $v[0].'<br>'; }else{ $ck_add_q .= $v.'<br>'; }
                        }
                    }
                }
                $ck_add_q .= '</div>';
            }

            $content = $mailContent['email_body'];
            
            $content = str_replace('[order_number]',$order_number,$content); 
            $content = str_replace('[order_date]',$order_date,$content); 
            $content = str_replace('[order_status]',$order_status,$content); 
            
            $content = str_replace('[checkout_billing_detail]',$checkout_billing_detail,$content); 
            $content = str_replace('[checkout_shipping_detail]',$checkout_shipping_detail,$content); 
            $content = str_replace('[checkout_additional_questions]',$ck_add_q,$content); 
            $content = str_replace("[customer's_company_name]",$consumerData['business_name'],$content); 

           
            $subject = $mailContent['email_subject'];
            $subject = str_replace('[order_number]',$order_number,$subject); 
            $subject = str_replace("[customer's_company_name]",$consumerData['business_name'],$subject); 
           


            $all_suppliers =  array_unique(array_column($order_detail['products'],'supplier_id'));

            foreach($all_suppliers as $sup_id){

                $supplierDetail = $this->db->query("SELECT email,firstname,lastname FROM user AS u JOIN supplier as s ON u.user_id=s.user_id WHERE s.supplier_id=".$sup_id)->row_array();

                if(!empty($supplierDetail)){


                    $order_product_detail = '';


                    if(!empty($order_detail['products'])){
                       $order_product_detail = '<table style="border:1px solid;border-collapse: collapse; width:100%; margin-top:20px;">
                            <thead>
                                <tr><th colspan="3" style="border: 1px solid;text-align: center;">Audit Products Detail</th>
                                </tr><tr><th style="border: 1px solid;text-align: left;">Name</th><th style="border: 1px solid;text-align: right;">Quantity</th><th style="border: 1px solid;text-align: right;">Price</th>
                                </tr></thead><tbody>';
                    
                        foreach($order_detail['products'] as $op){

                            if($op['supplier_id']==$sup_id){
                                $price = numfmt_format_currency($this->fmt,$op['prod_price'], "USD").' USD';
                                $order_product_detail .= '<tr><td style="border: 1px solid">'.$op['prod_name'].'</td><td style="border: 1px solid;text-align: right;">'.$op['prod_qty'].'</td><td style="border: 1px solid;text-align: right;">'.$price.'</td></tr>';
                            }
                        }
                        $priceSum = array_sum(array_column($order_detail['products'], 'prod_price'));
                        $totalPrice = numfmt_format_currency($this->fmt,$priceSum, "USD").' USD';
                        $order_product_detail .= '<tr><td colspan="2" style="border: 1px solid;text-align: right;">Cart Total</td><td style="border: 1px solid;text-align: right;">'.$totalPrice.'</td></tr></tbody></table>';
                    }

                    $to_name= $supplierDetail['firstname'].' '.$supplierDetail['lastname'];

                    $cont = $content;
                    $cont = str_replace('[order_product_detail]',$order_product_detail,$cont); 
                    $cont = str_replace('[name]',$to_name,$cont);

                    $message = $this->load->view('include/mail_template',array('body'=>$cont),true);
                    $mailresponce = $this->sendGridMail('',$supplierDetail['email'],$subject,$message);
                }
            }
        }
    }

    public function order_mail_kam($oid){

       // echo "<pre>"; print_r($order_detail); exit;
        $only_audit = true; 
        $order_detail = $this->shop_model->order_summary($oid,$only_audit);
        $consumer_id = $order_detail['detail']['createdby'];


        $consumer = $this->generalmodel->getparticularData('user_id,createdby,email,firstname,lastname','user',"user_id=".$consumer_id,'row_array');
        $ia = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$consumer['createdby']),"row_array");
        $kams = $this->generalmodel->getparticularData('assign_to,ia_id,user_id,business_name','indassociation',array('assign_to'=>$ia['user_id']),"row_array"); 
        $data = $this->generalmodel->getparticularData('firstname,lastname,email,user_id','user',array('user_id'=>$kams['user_id']),"row_array");

        $sendername = 'ETA';
        $to = $data['email'];

        $mailContent = $this->generalmodel->mail_template('email_subject,email_body','order_created_kam_csr');


        $receipent_name = $data['firstname'].' '.$data['lastname'];
        $order_number = $order_detail['detail']['orders_id'];

        $odate = gmdate_to_mydate($order_detail['detail']['createdate'],$this->localtimzone);
        $order_date = date('m/d/Y',strtotime($odate));
        $order_status = 'Pending Audit';
        $order_product_detail = '';


        if(!empty($order_detail['products'])){
           $order_product_detail = '<table style="border:1px solid;border-collapse: collapse; width:100%; margin-top:20px;">
                <thead>
                    <tr><th colspan="3" style="border: 1px solid;text-align: center;">Audit Products Detail</th>
                    </tr><tr><th style="border: 1px solid;text-align: left;">Name</th><th style="border: 1px solid;text-align: right;">Quantity</th><th style="border: 1px solid;text-align: right;">Price</th>
                    </tr></thead><tbody>';
        
            foreach($order_detail['products'] as $op){

                $price = numfmt_format_currency($this->fmt,$op['prod_price'], "USD").' USD';
                $order_product_detail .= '<tr><td style="border: 1px solid">'.$op['prod_name'].'</td><td style="border: 1px solid;text-align: right;">'.$op['prod_qty'].'</td><td style="border: 1px solid;text-align: right;">'.$price.'</td></tr>';
            }
            $priceSum = array_sum(array_column($order_detail['products'], 'prod_price'));
            $totalPrice = numfmt_format_currency($this->fmt,$priceSum, "USD").' USD';
            $order_product_detail .= '<tr><td colspan="2" style="border: 1px solid;text-align: right;">Cart Total</td><td style="border: 1px solid;text-align: right;">'.$totalPrice.'</td></tr></tbody></table>';
        }
        

        $cdata = getcountry_data($order_detail['detail']['billing_country']); 

        $checkout_billing_detail = '<h4>Billing Details</h4><p style="line-height:22px;">';
        $checkout_billing_detail .= $order_detail['detail']['billing_fname'].' '.$order_detail['detail']['billing_lname'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_email'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_address'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_city'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_state'].'<br>';
        $checkout_billing_detail .= $cdata['country_name'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_postalcode'].'</p>';


        $checkout_shipping_detail = '<h4>Shipping Details</h4>';
        if($order_detail['detail']['is_billing_same']!='1'){
            $checkout_shipping_detail .= '<p style="line-height:22px;">'.$order_detail['detail']['shipping_address'].'<br>'.$order_detail['detail']['shipping_city'].'<br>'.$order_detail['detail']['shipping_state'].'</p>';
        }else{
            $checkout_shipping_detail .= '<p style="line-height:22px;">Shipping Address is same as billing address</p>';
        }

        $add_fields = unserialize($order_detail['detail']['add_fields']);
        $ck_add_q = '';
        if(!empty($add_fields)){
            $ck_add_q .= '<div style="line-height:24px;">';
            foreach($add_fields as $key=>$add){
                if($key=='files'){

                $ck_add_q .= '<table><tbody>';
                    foreach($add as $file){
                        foreach($file as $k=>$f){
                            $link = base_url('uploads/additional_fields/').$f;
                            if(!empty($f)){

                                $ck_add_q .= '<tr style="line-height:50px;" ><td>'.$k.':</td><td><a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 10px 10px;text-decoration: none;border-radius: 5px;" target="_blank" download="">Download</a></td></tr>';
                            }else{
                                $ck_add_q .= '<tr><td>'.$k.':</td><td>Not Uploaded</td></tr>';
                            }
                        }
                    }
                $ck_add_q .= '</tbody></table>';
                }else{
                    foreach($add as $k=>$v){
                        $ck_add_q .= '<b>'.$k.':</b>';
                        if(is_array($v)){ $ck_add_q .= $v[0].'<br>'; }else{ $ck_add_q .= $v.'<br>'; }
                    }
                }
            }
            $ck_add_q .= '</div>';
        }

        $content = $mailContent['email_body'];
        $content = str_replace('[name]',$receipent_name,$content);
        $content = str_replace('[order_number]',$order_number,$content); 
        $content = str_replace('[order_date]',$order_date,$content); 
        $content = str_replace('[order_status]',$order_status,$content); 
        $content = str_replace('[order_product_detail]',$order_product_detail,$content); 
        $content = str_replace('[checkout_billing_detail]',$checkout_billing_detail,$content); 
        $content = str_replace('[checkout_shipping_detail]',$checkout_shipping_detail,$content); 
        $content = str_replace('[checkout_additional_questions]',$ck_add_q,$content); 

        $message = $this->load->view('include/mail_template',array('body'=>$content),true);
        $subject = $mailContent['email_subject'];
        $subject = str_replace('[order_number]',$order_number,$subject); 
        $mailresponce = $this->sendGridMail('',$to,$subject,$message);




        //print_r($mailresponce); exit;
        //$this->load->view('include/mail_template',array('body'=>$content));
        //echo $to.'<br>'.$subject.'<br>'.$message;

    }

    public function order_mail_csr($oid){

       // echo "<pre>"; print_r($order_detail); exit;
        $only_audit = true; 
        $order_detail = $this->shop_model->order_summary($oid,$only_audit);
        $consumer_id = $order_detail['detail']['createdby'];


        $consumer = $this->generalmodel->getparticularData('user_id,createdby,email,firstname,lastname','user',"user_id=".$consumer_id,'row_array');
        $ia = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('user_id'=>$consumer['createdby']),"row_array");
        $kams = $this->generalmodel->getparticularData('assign_to,ia_id,user_id,business_name','indassociation',array('assign_to'=>$ia['user_id']),"row_array"); 
        $data = $this->generalmodel->getparticularData('firstname,lastname,email,contactno','user',array('assign_to'=>$kams['user_id']),"row_array");

        $sendername = 'ETA';
        $to = $data['email'];

        $mailContent = $this->generalmodel->mail_template('email_subject,email_body','order_created_kam_csr');


        $receipent_name = $data['firstname'].' '.$data['lastname'];
        $order_number = $order_detail['detail']['orders_id'];

        $odate = gmdate_to_mydate($order_detail['detail']['createdate'],$this->localtimzone);
        $order_date = date('m/d/Y',strtotime($odate));
        $order_status = 'Pending Audit';
        $order_product_detail = '';


        if(!empty($order_detail['products'])){
           $order_product_detail = '<table style="border:1px solid;border-collapse: collapse; width:100%; margin-top:20px;">
                <thead>
                    <tr><th colspan="3" style="border: 1px solid;text-align: center;">Audit Products Detail</th>
                    </tr><tr><th style="border: 1px solid;text-align: left;">Name</th><th style="border: 1px solid;text-align: right;">Quantity</th><th style="border: 1px solid;text-align: right;">Price</th>
                    </tr></thead><tbody>';
        
            foreach($order_detail['products'] as $op){

                $price = numfmt_format_currency($this->fmt,$op['prod_price'], "USD").' USD';
                $order_product_detail .= '<tr><td style="border: 1px solid">'.$op['prod_name'].'</td><td style="border: 1px solid;text-align: right;">'.$op['prod_qty'].'</td><td style="border: 1px solid;text-align: right;">'.$price.'</td></tr>';
            }
            $priceSum = array_sum(array_column($order_detail['products'], 'prod_price'));
            $totalPrice = numfmt_format_currency($this->fmt,$priceSum, "USD").' USD';
            $order_product_detail .= '<tr><td colspan="2" style="border: 1px solid;text-align: right;">Cart Total</td><td style="border: 1px solid;text-align: right;">'.$totalPrice.'</td></tr></tbody></table>';
        }
        

        $cdata = getcountry_data($order_detail['detail']['billing_country']); 

        $checkout_billing_detail = '<h4>Billing Details</h4><p style="line-height:22px;">';
        $checkout_billing_detail .= $order_detail['detail']['billing_fname'].' '.$order_detail['detail']['billing_lname'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_email'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_address'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_city'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_state'].'<br>';
        $checkout_billing_detail .= $cdata['country_name'].'<br>';
        $checkout_billing_detail .= $order_detail['detail']['billing_postalcode'].'</p>';


        $checkout_shipping_detail = '<h4>Shipping Details</h4>';
        if($order_detail['detail']['is_billing_same']!='1'){
            $checkout_shipping_detail .= '<p style="line-height:22px;">'.$order_detail['detail']['shipping_address'].'<br>'.$order_detail['detail']['shipping_city'].'<br>'.$order_detail['detail']['shipping_state'].'</p>';
        }else{
            $checkout_shipping_detail .= '<p style="line-height:22px;">Shipping Address is same as billing address</p>';
        }

        $add_fields = unserialize($order_detail['detail']['add_fields']);
        $ck_add_q = '';
        if(!empty($add_fields)){
            $ck_add_q .= '<div style="line-height:24px;">';
            foreach($add_fields as $key=>$add){
                if($key=='files'){

                $ck_add_q .= '<table><tbody>';
                    foreach($add as $file){
                        foreach($file as $k=>$f){
                            $link = base_url('uploads/additional_fields/').$f;
                            if(!empty($f)){

                                $ck_add_q .= '<tr style="line-height:50px;" ><td>'.$k.':</td><td><a href="'.$link.'" style="background: #8dc63f; color: #fff; padding: 10px 10px;text-decoration: none;border-radius: 5px;" target="_blank" download="">Download</a></td></tr>';
                            }else{
                                $ck_add_q .= '<tr><td>'.$k.':</td><td>Not Uploaded</td></tr>';
                            }
                        }
                    }
                $ck_add_q .= '</tbody></table>';
                }else{
                    foreach($add as $k=>$v){
                        $ck_add_q .= '<b>'.$k.':</b>';
                        if(is_array($v)){ $ck_add_q .= $v[0].'<br>'; }else{ $ck_add_q .= $v.'<br>'; }
                    }
                }
            }
            $ck_add_q .= '</div>';
        }

        $content = $mailContent['email_body'];
        $content = str_replace('[name]',$receipent_name,$content);
        $content = str_replace('[order_number]',$order_number,$content); 
        $content = str_replace('[order_date]',$order_date,$content); 
        $content = str_replace('[order_status]',$order_status,$content); 
        $content = str_replace('[order_product_detail]',$order_product_detail,$content); 
        $content = str_replace('[checkout_billing_detail]',$checkout_billing_detail,$content); 
        $content = str_replace('[checkout_shipping_detail]',$checkout_shipping_detail,$content); 
        $content = str_replace('[checkout_additional_questions]',$ck_add_q,$content); 

        $message = $this->load->view('include/mail_template',array('body'=>$content),true);
        $subject = $mailContent['email_subject'];
        $subject = str_replace('[order_number]',$order_number,$subject); 
        $mailresponce = $this->sendGridMail('',$to,$subject,$message);




        //print_r($mailresponce); exit;
        //$this->load->view('include/mail_template',array('body'=>$content));
        //echo $to.'<br>'.$subject.'<br>'.$message;

    }

    /*
    public function orderdetail(){

        $this->load->library('paypal_lib'); 
        $oid = '6C280633GF148070C';        
        //$oid = '7YG81450K67089621'; 
        $return  = $this->paypal_lib->order_detail($oid);
        $r_orderDetail = $return['ORDER']['purchase_units'][0];

        echo "<pre>"; print_r($return); 
   
    }

    public function paydetail(){

        $this->load->library('paypal_lib'); 

        $domain = 'http://45.33.105.92/ETA/';
        $rest_client_id = 'Ae8BII3kPtEQLbBURBUulwYkLiBMuhrLWzFIeDKTM5lJhxKp5tjPOF7m6pnJMuDlPBhlHc3i7jnbNIta';
        $rest_client_secret = "ELosmucoqRiksKoV993cvKbSGXq8rciK_uZw3Y60XHjruGgmlTiDt3iRkuOBn_QaqKpppi0tWciYn8_D";
        $configArray = array(
            'Sandbox' => TRUE,
            'ClientID' => $rest_client_id,
            'ClientSecret' => $rest_client_secret,
            'LogResults' => false,
            'LogPath' =>  $_SERVER['DOCUMENT_ROOT'].'/ETA/logs/',
            'LogLevel' => 'DEBUG'
        );


        $configArray = array(
            'Sandbox' => $sandbox,
            'ClientID' => $rest_client_id,
            'ClientSecret' => $rest_client_secret,
            'LogResults' => $log_results,
            'LogPath' => $log_path,
            'LogLevel' => $log_level
        );

        $PayPal = new CheckoutOrdersAPI($configArray);

        $authorization_id = '3HT90723074597802';        // The ID of the authorized payment for which to show details.

        $response = $PayPal->GetAuthorizePaymentDetails($authorization_id);

        echo "<pre>";
        print_r($response);
        exit;

        echo "<pre>"; print_r($return); 
   
    }
    */

}