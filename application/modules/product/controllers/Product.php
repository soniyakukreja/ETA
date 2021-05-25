<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Product extends MY_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $data['meta_title'] = "Product";
        $this->load->view('product/product',$data);
    }

    public function ajax()
    {
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        //$datatables->query('SELECT product_name,product_sku,type,prod_cat_id,supplier_id,wsale_price,c_price,prod_status,prod_id FROM product');
        if(in_array('PROD_D',$perms)){
            $que = "SELECT  m.prod_id as productid ,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
        }else{
            $que = "SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
        }
                // // edit 'id' column

         $datatables->query($que);
                // // edit 'id' column
         if(in_array('PROD_D',$perms)){
        $datatables->edit('productid', function ($data) {
                $lic = 'SELECT prod_id FROM prodassigntolicensee WHERE status="1" AND prod_id = '.$data['productid'];
                $query=$this->db->query($lic);
                $obj= $query->row_array();
               if($data["productid"]==$obj["prod_id"]){ $chk = "checked=checked";}else{ $chk ="";}
                    return  '<input type="checkbox" class="case" name="id[]" value="'.$data['prod_id'].'" '.$chk.' />';
               
                });
         }
        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });

		$datatables->edit('prod_status', function ($data) {
			if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
		});
                $datatables->edit('prod_id',function($data) use($perms){
                    
                    $menu='';
                    if(in_array('PROD_VD',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('product/product/viewproduct/').encoding($data['prod_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                        </li>';
                    }

                    if(in_array('PROD_E',$perms)){
                        $menu.='<li>
                        <a href="'.site_url('product/product/editproduct/').encoding($data['prod_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        </li>';
                    }

                    if(in_array('PROD_D',$perms)){
                        $menu.='<li>
                        <a href="javascript:void(0)" link="'.site_url('product/product/deleteproduct/').encoding($data['prod_id']).'" class="deleteEntry">
                            <span class="glyphicon glyphicon-trash"></span> Delete
                        </a>
                        </li>';
                    }    

                    return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                '.$menu.'    
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }
    
     public function addproduct(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){


            if($this->form_validation->run('add_product')){
               
                $createddate =  date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];

                $ipaddress = $this->input->ip_address();

                $profilepicture = $this->input->post('productimg_h');
                $startdate = get_ymd_format($this->input->post('prod_dis_startdate'));
                $enddate = get_ymd_format($this->input->post('prod_dis_enddate'));

$wsale_price = $this->input->post('wsale_price');
$l_price = $this->input->post('l_price');
$ia_price = $this->input->post('ia_price');
$c_price = $this->input->post('c_price');


if(floatval($l_price) <= floatval($wsale_price)){
    $return = array('success'=>false,'msg'=>'Licensee Price must be greater than Wholesale Price');
    echo json_encode($return); exit;
}elseif(floatval($ia_price) <= floatval($l_price)){
    $return = array('success'=>false,'msg'=>'Industry Association Price must be greater than Licensee Price');
    echo json_encode($return); exit;    
}elseif(floatval($c_price) <= floatval($ia_price)){
    $return = array('success'=>false,'msg'=>'Consumer Price must be greater than Industry Association Price');
    echo json_encode($return); exit;    
}


                $data = array(
                    'product_name' => $this->input->post('product_name'), 
                    'product_sku' => $this->input->post('product_sku'), 
                    'prod_cat_id' => $this->input->post('prod_cat_id'), 
                    'supplier_id' => $this->input->post('supplier_id'), 
                    'type' => $this->input->post('type'), 
                    'wsale_price' => $this->input->post('wsale_price'), 
                    'l_price' => $this->input->post('l_price'), 
                    'ia_price' => $this->input->post('ia_price'), 
                    'c_price' => $this->input->post('c_price'), 
                    'prod_dis' => $this->input->post('prod_dis'), 
                    'prod_dis_startdate' => $startdate, 
                    'prod_dis_enddate' => $enddate, 
                    'prod_status' => $this->input->post('prod_status'), 
                    'ck_form_id' => $this->input->post('ck_form_id'), 
                    'prod_description' => $this->input->post('prod_description'), 
                    'urole_id' => '4',
                    'platform' => $this->agent->platform(),
                    'browser' => $this->agent->browser(),
                    'ipadrress' => $ipaddress,
                    'prod_image' => $profilepicture,
                    'createdby' => $createdby, 
                    'createdate ' => $createddate, 
                );

                $query = $this->generalmodel->add('product',$data);
                if(!empty($query)){
                    if(!empty($profilepicture)){
                    $src ='./tmp_upload/'.$profilepicture;
                    $destination= './uploads/product_img/'.$profilepicture;
                    rename($src, $destination); 
                    }
                    $return = array('success'=>true,'msg'=>'Product addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['type'] = $this->generalmodel->get_data_by_condition('rolename,urole_id','user_role',array('urole_id!='=>1));
            $data['category'] = $this->generalmodel->get_all_record('product_category');
            $data['supplier'] = $this->generalmodel->get_all_record('supplier');
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['form_templates'] = $this->generalmodel->form_templates(array('frm_status'=>'1'));
            $data['meta_title'] = "Add Product";
            $this->load->view('product_form',$data);
        }
    }

    public function editproduct($id)
    {
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_product')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

 
                $ipaddress = $this->input->ip_address();

                $profilepicture = $this->input->post('productimg_h');
                $id = $this->input->post('id');
                
                $startdate = get_ymd_format($this->input->post('prod_dis_startdate'));
                $enddate = get_ymd_format($this->input->post('prod_dis_enddate'));

$wsale_price = $this->input->post('wsale_price');
$l_price = $this->input->post('l_price');
$ia_price = $this->input->post('ia_price');
$c_price = $this->input->post('c_price');


if(floatval($l_price) <= floatval($wsale_price)){
    $return = array('success'=>false,'msg'=>'Licensee Price must be greater than Wholesale Price');
    echo json_encode($return); exit;
}elseif(floatval($ia_price) <= floatval($l_price)){
    $return = array('success'=>false,'msg'=>'Industry Association Price must be greater than Licensee Price');
    echo json_encode($return); exit;    
}elseif(floatval($c_price) <= floatval($ia_price)){
    $return = array('success'=>false,'msg'=>'Consumer Price must be greater than Industry Association Price');
    echo json_encode($return); exit;    
}
               
                $data = array(
                    'product_name' => $this->input->post('product_name'), 
                    'product_sku' => $this->input->post('product_sku'), 
                    'prod_cat_id' => $this->input->post('prod_cat_id'), 
                    'supplier_id' => $this->input->post('supplier_id'), 
                    'type' => $this->input->post('type'), 
                    'wsale_price' => $this->input->post('wsale_price'), 
                    'l_price' => $this->input->post('l_price'), 
                    'ia_price' => $this->input->post('ia_price'), 
                    'c_price' => $this->input->post('c_price'), 
                    'prod_dis' => $this->input->post('prod_dis'), 
                    'prod_dis_startdate' =>  $startdate, 
                    'prod_dis_enddate' => $enddate, 
                    'prod_status' => $this->input->post('prod_status'), 
                    'ck_form_id' => $this->input->post('ck_form_id'),
                     'prod_description' => $this->input->post('prod_description'), 
                     'urole_id' => '4', 
                    'platform' => $this->agent->platform(),
                    'browser' => $this->agent->browser(),
                    'ipadrress' => $ipaddress,
                    // 'createdby' => $createdby, 
                    // 'prod_image' => $profilepicture
                );
                // print_r($data); exit;
                if($profilepicture!=''){
                    $data['prod_image']= $profilepicture;
                }
              
                $query = $this->generalmodel->updaterecord('product',$data,'prod_id='.$id);
            
                if($query>0){
                    if(!empty($profilepicture)){
                    $src ='./tmp_upload/'.$profilepicture;
                    $destination= './uploads/product_img/'.$profilepicture;
                    rename($src, $destination); 
                    }
                    $return = array('success'=>true,'msg'=>'Product Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['type'] = $this->generalmodel->get_data_by_condition('rolename,urole_id','user_role',array('urole_id!='=>1));
            $data['category'] = $this->generalmodel->get_all_record('product_category');
            $data['supplier'] = $this->generalmodel->get_all_record('supplier');
            $data['form_templates'] = $this->generalmodel->form_templates(array('frm_status'=>'1'));
            $data['product']=$this->generalmodel->getSingleRowById('product', 'prod_id', $id, $returnType = 'array');
            $data['meta_title'] = "Edit Product";
            $this->load->view('editproduct',$data);
        }
    }

     public function viewproduct($id)
    {
         $id = decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','product','product_category','product.prod_cat_id=product_category.prod_cat_id','prod_id='.$id);
       $data['meta_title'] = "View Product";
       $this->load->view('viewproduct',$data);
    }

    public function deleteproduct($id)
    {
        $id = decoding($id);
	   if ($this->input->is_ajax_request()) {

            $data = array('prod_del'=>'0');
            $this->generalmodel->updaterecord('product',$data,'prod_id='.$id);

            $return = array('success'=>true,'msg'=>'Entry Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }

    public function productbylic()
    {
        $data['meta_title'] = "Product";
        $this->load->view('product/productlic',$data);
    }

    public function ajaxlic()
    {
        $userid = $this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);
        //$datatables->query('SELECT product_name,product_sku,type,prod_cat_id,supplier_id,wsale_price,c_price,prod_status,prod_id FROM product');
        $datatables->query('SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id LEFT JOIN prodassigntolicensee as p ON m.prod_id = p.prod_id WHERE m.prod_del!="0" AND m.urole_id="2" AND p.lic_id="'.$userid.'"');
                // // edit 'id' column
        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });
        $datatables->edit('prod_status', function ($data) {
            if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
        });
                $datatables->edit('prod_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'licensee/viewproduct/'.$data['prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                   
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }

    public function productbyia()
    {
        $data['meta_title'] = "Product";
        $this->load->view('product/productia',$data);
    }

    public function ajaxia()
    {
        
        $datatables = new Datatables(new CodeigniterAdapter);
        //$datatables->query('SELECT product_name,product_sku,type,prod_cat_id,supplier_id,wsale_price,c_price,prod_status,prod_id FROM product');
        $datatables->query('SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id WHERE m.prod_del!="0" AND m.urole_id="3"');

        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });
                // // edit 'id' column
        $datatables->edit('prod_status', function ($data) {
            if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
        });
                $datatables->edit('prod_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'industryassociation/viewproduct/'.$data['prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }

    public function productbysupplier()
    {
        $data['meta_title'] = "Product";
        $this->load->view('product/productsup',$data);
    }

    public function ajaxsupplier()
    {
        $supplier=$this->session->userdata['supplierid'];
        $datatables = new Datatables(new CodeigniterAdapter);
        //$datatables->query('SELECT product_name,product_sku,type,prod_cat_id,supplier_id,wsale_price,c_price,prod_status,prod_id FROM product');
        if(!empty($supplier)){
            $datatables->query('SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id WHERE m.prod_del!="0"  and c.user_id="'.$supplier.'"');    
        }
        
        // edit 'id' column
        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });
        $datatables->edit('prod_status', function ($data) {
            if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
        });
                $datatables->edit('prod_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url('supplier/viewproduct/').encoding($data['prod_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                   
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }



    /******************* Category *************************/

     public function addcategory(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            if($this->form_validation->run('add_category')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $data = array(
                     
                    'prod_cat_name' => $this->input->post('prod_cat_name'), 
                    'prod_cat_parent_category_id' => $this->input->post('prod_cat_parent_category_id'), 
                    'prod_cat_status' => '1', 
                    'createdby' => $createdby, 
                    'createddate' => $createddate, 
                   
                );

              
                $query = $this->generalmodel->add('product_category',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Product Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
            $data['category'] = $this->generalmodel->get_data_by_condition('prod_cat_name,prod_cat_id','product_category',array('prod_cat_status'=>1));
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['meta_title'] = "Add Product Category";
            $this->load->view('product_category',$data);
        }
    }

     public function editcategory($id){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_category')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $id =$this->input->post('id');
                $data = array(
                     
                    'prod_cat_name' => $this->input->post('prod_cat_name'), 
                    'prod_cat_parent_category_id' => $this->input->post('prod_cat_parent_category_id'), 
                    'prod_cat_status' => $this->input->post('prod_cat_status'), 
                   
                );
               
                $query = $this->generalmodel->updaterecord('product_category',$data,'prod_cat_id='.$id);

                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Product Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
            $id = decoding($id);
            $data['category'] = $this->generalmodel->get_data_by_condition('prod_cat_id,prod_cat_name','product_category',array('prod_cat_id!='=>$id,'prod_cat_parent_category_id!='=>$id,'prod_cat_status'=>1));
            $data['cate']=$this->generalmodel->getSingleRowById('product_category', 'prod_cat_id', $id, $returnType = 'array');
            $data['countrylist'] = $this->generalmodel->countrylist();
            $data['meta_title'] = "Edit Product Category";
            $this->load->view('editcategory',$data);
        }
    }
  
    public function category()
    {
        $data['meta_title'] = "Product Category";
        $this->load->view('product/category',$data);
    }

    public function ajaxcate()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $perms=explode(",",$this->userdata['upermission']);
        
        $datatables->query('select t.`prod_cat_name` as category, s.`prod_cat_name` as parent_category,t.prod_cat_status,t.`prod_cat_id` from product_category as t left join product_category s on t.`prod_cat_parent_category_id`=s.`prod_cat_id` where t.prod_cat_status!="2"');

		$datatables->edit('parent_category', function ($data) {
	            if(is_null($data['parent_category'])){
	               $st= '-';
	            }else{
	               $st= $data['parent_category'];
	            }
	                return $st; 
	    });

        $datatables->edit('prod_cat_status', function($data) use($perms){
            if($data['prod_cat_status']=='1'){
               $st= 'Active';
            }else{
               $st= 'Inactive';
            }
                return $st; 
        });

                // // edit 'id' column
        $datatables->edit('prod_cat_id', function($data) use($perms){
                
                $menu='';
                if(in_array('PRODC_VD', $perms)){                
                    $menu.='<li>
                        <a href="'.site_url().'product/product/viewcategory/'.encoding($data['prod_cat_id']).'">
                            <span class="glyphicon glyphicon-eye-open"></span> View
                        </a>
                    </li>';
                }

                if(in_array('PRODC_E', $perms)){                
                    $menu.='<li>
                        <a href="'.site_url().'product/product/editcategory/'.encoding($data['prod_cat_id']).'">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                    </li>';
                }

                if(in_array('PRODC_D', $perms)){                
                    $menu.='<li>
                        <a href="javascript:void(0)" link="'.site_url().'product/product/deletecate/'.encoding($data['prod_cat_id']).'" class="deleteEntry">
                            <span class="glyphicon glyphicon-trash"></span> Delete
                        </a>
                    </li>';
                }        

                return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                '.$menu.'   
                                                                </ul></div>';
        });

        echo $datatables->generate();
    }

    public function deletecate($id)
    {
        if ($this->input->is_ajax_request()) {
            $id = decoding($id);
            $data = array('prod_cat_status'=>'2');
            $this->generalmodel->updaterecord('product_category',$data,'prod_cat_id='.$id);
            $this->generalmodel->updaterecord('product',array('prod_cat_id'=>'1'),'prod_cat_id='.$id);
            $return = array('success'=>true,'msg'=>'Entry Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }

    public function viewcategory($id)
    {
        $id = decoding($id);
       $data['cate']=$this->generalmodel->getSingleRowById('product_category', 'prod_cat_id', $id, $returnType = 'array');
       $data['meta_title'] = "View Product Category";
         $this->load->view('viewcategory',$data);
    }



    /******** Assign Product**********/

    public function productassign($id)
    {   
        $id = decoding($id);
        $data['lic_id']= $id;
        $data['meta_title'] = "Product";
        $this->load->view('product/productassign',$data);
    }

    public function assignprodlic($id)
    {
        $datatables = new Datatables(new CodeigniterAdapter);
        $que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as lic_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
   
        $datatables->query($que);
                // // edit 'id' column

        $datatables->edit('productid', function ($data) {
        		$lic = 'SELECT prod_id FROM prodassigntolicensee WHERE status="1" AND lic_id="'.$data['lic_id'].'" AND prod_id = '.$data['productid'];
                $query=$this->db->query($lic);
				$obj= $query->row_array();
               if($data["productid"]==$obj["prod_id"]){ $chk = "checked=checked";}else{ $chk ="";}
                    return  '<input type="checkbox" class="case" name="prod_id[]" value="'.$data['prod_id'].'" '.$chk.' />';
               
                });

        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });
        $datatables->edit('prod_status', function ($data) {
            if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
        });
                $datatables->edit('prod_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" style="border:none;">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'licensee/viewproduct/'.encoding($data['prod_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                   
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }

    public function updateproduct(){
    	$proidz="";
        $lic_id = $this->input->post('lic_id');
        $prod_id = $this->input->post('prod_id');
        if($prod_id == '')
        {

        	$proidz=0;
        }else{

        	$proidz = implode(',',$prod_id);
        }
        $ldata="";
         $assigndate =  date('Y-m-d h:i:s');
         $assignby = $this->userdata['user_id'];

         if($proidz==0 ){
         	$this->generalmodel->updaterecord('licensee',array('lic_prod_assign'=>0),'lic_id='.$lic_id);
	        $noprod = 'UPDATE `prodassigntolicensee` SET `status`= 0 WHERE lic_id= "'.$lic_id.'" AND prod_id NOT IN ('.$proidz.')';
	        // print_r($noprod); exit;
	        $qury = $this->db->query($noprod);
    	}else if($prod_id!=""){	
	        $noprod = 'UPDATE `prodassigntolicensee` SET `status`= 0 WHERE lic_id= "'.$lic_id.'" AND prod_id NOT IN ('.$proidz.')';
	        // print_r($noprod); exit;
	        $this->db->query($noprod);

	        for($i=0; $i<count($prod_id); $i++)
	        {
			   $ldata = array('lic_prod_assign'=>1);
	           $data = array(
	                    'prod_id'=>$prod_id[$i],
	                    'lic_id'=>$lic_id,
	                    'assignby'=>$assignby,
	                    'assigndate'=>$assigndate,
	                    'status'=>1
	           );

	           $this->generalmodel->updaterecord('licensee',$ldata,'lic_id='.$lic_id);

	           $query = $this->generalmodel->getparticularData("prod_id",'prodassigntolicensee',"`prod_id`=".$prod_id[$i]." AND `lic_id`= $lic_id","row_array");

				if($query){
	           		$qury = $this->generalmodel->updaterecord('prodassigntolicensee',array('status'=>1),array('lic_id'=>$lic_id,'prod_id'=>$prod_id[$i]));
										
				}else{
	           		
	           		$qury = $this->generalmodel->add('prodassigntolicensee',$data);

				}

	        }
	    }

	            
	        
            if(!empty($qury)){
                  
                    $return = array('success'=>true,'msg'=>'Product Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
           
            echo json_encode($return); exit;
          

    }


    public function productassignia($id)
    {
        $data['ia_id']= $id;
        $data['meta_title'] = "Product";
        $this->load->view('product/productassignia',$data);
    }

    public function assignprodia($id)
    {
        $lic = $this->generalmodel->getparticularData("lic_prod_assign",'licensee',"`user_id`=".$this->userdata['user_id'],"row_array");
        $ia = $this->generalmodel->getparticularData("createdby,ia_prod_assign",'indassociation',array('ia_id'=>$id),"row_array");

        $datatables = new Datatables(new CodeigniterAdapter);
        if($this->userdata['dept_id']==1)
        {
       		// $que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as ia_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
            if($lic['lic_prod_assign']==0){
                $que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as ia_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
            }else{

            $que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as ia_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN prodassigntolicensee as p ON p.prod_id = m.prod_id LEFT JOIN licensee as l ON p.lic_id = l.lic_id WHERE m.prod_del!=0 AND p.status=1 AND l.user_id=".$ia['createdby']."";
            }

        }else
        {
        	if($lic['lic_prod_assign']==0){
        		$que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as ia_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
        	}else{

        	$que = "SELECT m.prod_id as productid,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id,".$id." as ia_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN prodassigntolicensee as p ON p.prod_id = m.prod_id LEFT JOIN licensee as l ON p.lic_id = l.lic_id WHERE m.prod_del!=0 AND p.status=1 AND l.user_id=".$this->userdata['user_id']."";
        	}
        }
   
        $datatables->query($que);
                // // edit 'id' column

        $datatables->edit('productid', function ($data) {
        		$lic = 'SELECT prod_id FROM prodassigntoia WHERE ia_id="'.$data['ia_id'].'" AND prod_id = '.$data['productid'];
                $query=$this->db->query($lic);
				$obj= $query->row_array();
               if($data["productid"]==$obj["prod_id"]){ $chk = "checked=checked";}else{ $chk ="";}
                    return  '<input type="checkbox" class="case" name="prod_id[]" value="'.$data['prod_id'].'" '.$chk.' />';
               
                });

        $datatables->edit('wsale_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['wsale_price'], "USD");
                });
        $datatables->edit('c_price', function ($data) {
                            
                    return  numfmt_format_currency($this->fmt,$data['c_price'], "USD");
                });
        $datatables->edit('prod_status', function ($data) {
            if($data['prod_status']==1){return 'Active';}else{return 'Inactive';}
        });
                $datatables->edit('prod_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'licensee/viewproduct/'.$data['prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                   
                                                                </ul><div>';
                });

        echo $datatables->generate();
    }

    // public function updateproductia(){
    //     $ia_id = $this->input->post('ia_id');
    //     $prod_id = $this->input->post('prod_id');
    //      $assigndate =  date('Y-m-d h:i:s');
    //      $assignby = $this->userdata['user_id'];
    //     for($i=0; $i<count($prod_id); $i++)
    //     {
    //         $ldata = array('ia_prod_assign'=>1);
    //        $this->generalmodel->updaterecord('indassociation',$ldata,'ia_id='.$ia_id);
    //        $data = array(
    //                 'prod_id'=>$prod_id[$i],
    //                 'ia_id'=>$ia_id,
    //                 'assignby'=>$assignby,
    //                 'assigndate'=>$assigndate
    //        );

    //        $query = $this->generalmodel->add('prodassigntoia',$data);
            
        
    //     }
    //         if(!empty($query)){
                  
    //                 $return = array('success'=>true,'msg'=>'Product Updated successfully');
    //             }else{
    //                 $return = array('success'=>false,'msg'=>'something went wrong');
    //             }
           
    //         echo json_encode($return); exit;
          

    // }

    public function updateproductia(){
    	$proidz="";
        $ia_id = $this->input->post('ia_id');
        $prod_id = $this->input->post('prod_id');
        if($prod_id == '')
        {

        	$proidz=0;
        }else{

        	$proidz = implode(',',$prod_id);
        }
        $ldata="";
         $assigndate =  date('Y-m-d h:i:s');
         $assignby = $this->userdata['user_id'];

         if($proidz==0 ){
         	$this->generalmodel->updaterecord('indassociation',array('ia_prod_assign'=>0),'ia_id='.$ia_id);
	        $noprod = 'UPDATE `prodassigntoia` SET `status`= 0 WHERE ia_id= "'.$ia_id.'" AND prod_id NOT IN ('.$proidz.')';
	        // print_r($noprod); exit;
	        $qury = $this->db->query($noprod);
    	}else if($prod_id!=""){	
	        $noprod = 'UPDATE `prodassigntoia` SET `status`= 0 WHERE ia_id= "'.$ia_id.'" AND prod_id NOT IN ('.$proidz.')';
	        // print_r($noprod); exit;
	        $this->db->query($noprod);

	        for($i=0; $i<count($prod_id); $i++)
	        {
			   $ldata = array('ia_prod_assign'=>1);
	           $data = array(
	                    'prod_id'=>$prod_id[$i],
	                    'ia_id'=>$ia_id,
	                    'assignby'=>$assignby,
	                    'assigndate'=>$assigndate,
	                    'status'=>1
	           );

	           $this->generalmodel->updaterecord('indassociation',$ldata,'ia_id='.$ia_id);

	           $query = $this->generalmodel->getparticularData("prod_id",'prodassigntoia',"`prod_id`=".$prod_id[$i]." AND `ia_id`= $ia_id","row_array");

				if($query){
	           		$qury = $this->generalmodel->updaterecord('prodassigntoia',array('status'=>1),array('ia_id'=>$ia_id,'prod_id'=>$prod_id[$i]));
										
				}else{
	           		
	           		$qury = $this->generalmodel->add('prodassigntoia',$data);

				}

	        }
	    }

	            
	        
            if(!empty($qury)){
                  
                    $return = array('success'=>true,'msg'=>'Product Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
           
            echo json_encode($return); exit;
          

    }

    public function export()
    {
        $q = $this->input->post('search');
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        if($q!=''){
            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0 AND (m.product_name LIKE "%'.$q.'%" OR m.product_sku LIKE "%'.$q.'%" OR m.type LIKE "%'.$q.'%" OR b.prod_cat_name LIKE "%'.$q.'%" OR c.supplier_fname LIKE "%'.$q.'%" OR m.wsale_price "%'.$q.'%" OR m.c_price LIKE "%'.$q.'%" OR m.prod_status LIKE "%'.$q.'%")';

        }else{

            // $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!="0"';
            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0';
        }

        // if(in_array('PROD_D',$perms)){
        //     $que = "SELECT  m.prod_id as productid ,m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
        // }else{
        //     $que = "SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!=0";
        // }

        // echo $items; exit;
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Product.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Product Name'),
                WriterEntityFactory::createCell('Product SKU'),
                WriterEntityFactory::createCell('Product Type'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('Supplier'),
                WriterEntityFactory::createCell('Wholesale Price'),
                WriterEntityFactory::createCell('Consumer Price'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['prod_status']==1){$st= 'Active';}else{$st ='Inactive';}
            $data[0] = $row['product_name'];
            $data[1] = $row['product_sku'];
            $data[2] = $row['type'];
            $data[3] = $row['prod_cat_name'];
            $data[4] = $row['supplier_fname'];
            $data[5] = numfmt_format_currency($this->fmt,$row['wsale_price'], "USD");
            $data[6] = numfmt_format_currency($this->fmt,$row['c_price'], "USD");
            $data[7] = $st;
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportlic()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        if($q!=''){
            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id LEFT JOIN prodassigntolicensee as p ON m.prod_id = p.prod_id WHERE m.prod_del!="0" AND m.urole_id="2" AND p.lic_id="'.$userid.'" AND (m.product_name LIKE "%'.$q.'%" OR m.product_sku LIKE "%'.$q.'%" OR m.type LIKE "%'.$q.'%" OR b.prod_cat_name LIKE "%'.$q.'%" OR c.supplier_fname LIKE "%'.$q.'%" OR m.wsale_price "%'.$q.'%" OR m.c_price LIKE "%'.$q.'%" OR m.prod_status LIKE "%'.$q.'%")';

        }else{

            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!="0" AND m.urole_id="2" AND p.lic_id="'.$userid.'"';
        }
        // $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id LEFT JOIN prodassigntolicensee as p ON m.prod_id = p.prod_id WHERE m.prod_del!="0" AND m.urole_id="2" AND p.lic_id="'.$userid.'"';
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Product.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Product Name'),
                WriterEntityFactory::createCell('Product SKU'),
                WriterEntityFactory::createCell('Product Type'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('Supplier'),
                WriterEntityFactory::createCell('Wholesale Price'),
                WriterEntityFactory::createCell('Consumer Price'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['prod_status']==1){$st= 'Active';}else{$st ='Inactive';}
            $data[0] = $row['product_name'];
            $data[1] = $row['product_sku'];
            $data[2] = $row['type'];
            $data[3] = $row['prod_cat_name'];
            $data[4] = $row['supplier_fname'];
            $data[5] = numfmt_format_currency($this->fmt,$row['wsale_price'], "USD");
            $data[6] = numfmt_format_currency($this->fmt,$row['c_price'], "USD");
            $data[7] = $st;
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportia()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        if($q!=''){
            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!="0" AND m.urole_id="3" AND p.lic_id="'.$userid.'" AND (m.product_name LIKE "%'.$q.'%" OR m.product_sku LIKE "%'.$q.'%" OR m.type LIKE "%'.$q.'%" OR b.prod_cat_name LIKE "%'.$q.'%" OR c.supplier_fname LIKE "%'.$q.'%" OR m.wsale_price "%'.$q.'%" OR m.c_price LIKE "%'.$q.'%" OR m.prod_status LIKE "%'.$q.'%")';

        }else{

            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id WHERE m.prod_del!="0" AND m.urole_id="3" AND p.lic_id="'.$userid.'"';
        }
        // $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id LEFT JOIN prodassigntolicensee as p ON m.prod_id = p.prod_id WHERE m.prod_del!="0" AND m.urole_id="3" AND p.lic_id="'.$userid.'"';
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Product.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Product Name'),
                WriterEntityFactory::createCell('Product SKU'),
                WriterEntityFactory::createCell('Product Type'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('Supplier'),
                WriterEntityFactory::createCell('Wholesale Price'),
                WriterEntityFactory::createCell('Consumer Price'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['prod_status']==1){$st= 'Active';}else{$st ='Inactive';}
            $data[0] = $row['product_name'];
            $data[1] = $row['product_sku'];
            $data[2] = $row['type'];
            $data[3] = $row['prod_cat_name'];
            $data[4] = $row['supplier_fname'];
            $data[5] = numfmt_format_currency($this->fmt,$row['wsale_price'], "USD");
            $data[6] = numfmt_format_currency($this->fmt,$row['c_price'], "USD");
            $data[7] = $st;
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportsup()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $supplier=$this->session->userdata['supplierid'];
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        if (!empty($supplier)) {
        	
        if($q!=''){
            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id WHERE m.prod_del!="0"  and c.user_id='.$supplier.' AND (m.product_name LIKE "%'.$q.'%" OR m.product_sku LIKE "%'.$q.'%" OR m.type LIKE "%'.$q.'%" OR b.prod_cat_name LIKE "%'.$q.'%" OR c.supplier_fname LIKE "%'.$q.'%" OR m.wsale_price "%'.$q.'%" OR m.c_price LIKE "%'.$q.'%" OR m.prod_status LIKE "%'.$q.'%")';

        }else{

            $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id WHERE m.prod_del!="0"  and c.user_id='.$supplier.'';
        }
        }
        // $items = 'SELECT m.product_name,m.product_sku,m.type,b.prod_cat_name,c.supplier_fname,m.wsale_price,m.c_price,m.prod_status,m.prod_id FROM product as m LEFT JOIN product_category as b ON m.prod_cat_id = b.prod_cat_id LEFT JOIN supplier as c ON m.supplier_id = c.supplier_id LEFT JOIN user as u ON m.createdby = u.user_id LEFT JOIN prodassigntolicensee as p ON m.prod_id = p.prod_id WHERE m.prod_del!="0" AND m.urole_id="5" AND p.lic_id="'.$userid.'"';
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Product.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Product Name'),
                WriterEntityFactory::createCell('Product SKU'),
                WriterEntityFactory::createCell('Product Type'),
                WriterEntityFactory::createCell('Category'),
                WriterEntityFactory::createCell('Supplier'),
                WriterEntityFactory::createCell('Wholesale Price'),
                WriterEntityFactory::createCell('Consumer Price'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['prod_status']==1){$st= 'Active';}else{$st ='Inactive';}
            $data[0] = $row['product_name'];
            $data[1] = $row['product_sku'];
            $data[2] = $row['type'];
            $data[3] = $row['prod_cat_name'];
            $data[4] = $row['supplier_fname'];
            $data[5] = numfmt_format_currency($this->fmt,$row['wsale_price'], "USD");
            $data[6] = numfmt_format_currency($this->fmt,$row['c_price'], "USD");
            $data[7] = $st;
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportcate()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        if($q!=''){
            $items = 'select t.`prod_cat_name` as category, s.`prod_cat_name` as parent_category,t.prod_cat_status,t.`prod_cat_id` from product_category as t left join product_category s on t.`prod_cat_parent_category_id`=s.`prod_cat_id` where t.prod_cat_status!="2" AND (prod_cat_name LIKE "%'.$q.'%" OR prod_cat_parent_category_id LIKE "%'.$q.'%" OR prod_cat_status "%'.$q.'%")';

        }else{

            $items = 'select t.`prod_cat_name` as category, s.`prod_cat_name` as parent_category,t.prod_cat_status,t.`prod_cat_id` from product_category as t left join product_category s on t.`prod_cat_parent_category_id`=s.`prod_cat_id` where t.prod_cat_status!="2"';
        }
        // $items = 'SELECT prod_cat_name,prod_cat_parent_category_id,prod_cat_status,prod_cat_id FROM product_category WHERE prod_cat_status!="2"';
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Product Category.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Category Name'),
                WriterEntityFactory::createCell('Parent Category'),
                WriterEntityFactory::createCell('Status'),
              
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            if($row['prod_cat_status']==1){$st= 'Active';}else{$st ='Inactive';}
            if(is_null($row['parent_category'])){
                   $pc= '-';
                }else{
                   $pc= $row['parent_category'];
                }
            $data[0] = $row['category'];
            $data[1] = $pc;
            $data[2] = $st;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    //==========expression of interest 

    public function int_expression(){
        $this->load->view('product/int_expression');
    }
    public function int_expression_ajax(){

         
        $perms=explode(",",$this->userdata['upermission']);
        

        $datatables = new Datatables(new CodeigniterAdapter);
        
        if($this->userdata['urole_id']==3){

            $userid =$this->userdata['user_id'];
            $datatables->query('SELECT CONCAT_WS(" ",firstname,lastname) AS username,p.product_name,ie.createdate,ie.int_id FROM `interest_expression` as ie 
            LEFT JOIN product as p ON p.prod_id = ie.prod_id
            LEFT JOIN user as u ON u.user_id = ie.customer_id
            WHERE `ia_id`='.$userid);
            
        }elseif($this->userdata['urole_id']==2){
            $userid =$this->userdata['user_id'];
            $datatables->query('SELECT CONCAT_WS(" ",firstname,lastname) AS username,p.product_name,ie.createdate,ie.int_id FROM `interest_expression` as ie 
            LEFT JOIN product as p ON p.prod_id = ie.prod_id
            LEFT JOIN user as u ON u.user_id = ie.customer_id
            WHERE `ia_id`='.$userid);
        }
        
                $datatables->edit('createdate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['createdate'],$localtimzone);
                    return date('m/d/Y',strtotime($createdate));
                });
                // edit 'id' column
                /*$datatables->edit('int_id', function($data){

                    return '<a class="btn sentInterest" href="javascript:void(0)" action="'.site_url().'industryassociation/sendIntofexpression/'.$data['int_id'].'">
                                Send Expression of Interest
                            </a>';

                
                });*/

        echo $datatables->generate();

    }

    public function sendIntofexpression($intId){
        if($this->input->is_ajax_request()){
            $intDetail = $this->generalmodel->interest_detail($intId);
            
            $licdata = $this->generalmodel->getlicdata($intDetail['lic_id']);

            $mailData = $this->generalmodel->mail_template('email_subject,email_body','int_expression_to_lic');
            $content =$mailData['email_body']; 

            $message = $this->load->view('include/mail_template',array('content'=>$content),true);

            $subject = $mailData['email_subject'];
            $mailresponce = $this->sendGridMail('',$licdata['email'],$subject,$message);
            if($mailresponce=="TRUE"){ 
                $return = array('success'=>true,'msg'=>'Mail of Interest Sent');
            }else{
                $return = array('success'=>false,'msg'=>'mail failed');
            } 
            echo json_encode($return);
        }

    }

    //==========expression of interest  end ===========//

 public function removeassign(){
        if ($this->input->is_ajax_request()) {
             $userid =$this->userdata['user_id'];
            $ids = $this->input->post('ids');
           
           $this->generalmodel->updaterecord('prodassigntolicensee',array('status'=>0),'prod_id NOT IN('.$ids.')');
            $return = array('success'=>true,'msg'=>'Records Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }

public function sendtestmail(){

        $to ="divyesh.rathore@gmail.com";
        $subject = "Test Subject ";
        $message="Test mail on 45";
        $mailresponce = $this->sendGridMail('',$to,$subject,$message);

        print_r($mailresponce); exit;
    }
    

}

