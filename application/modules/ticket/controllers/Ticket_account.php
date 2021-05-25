<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Ticket_account extends MX_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $this->load->view('ticket/ticket_account');
    }

    public function ajax()
    {
            
            $datatables = new Datatables(new CodeigniterAdapter);
            //$datatables->query('SELECT product_name,product_sku,type,prod_cat_id,supplier_id,wsale_price,c_price,prod_status,prod_id FROM product');
            $datatables->query('SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket_account as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.status="1"');
                    // // edit 'id' column
                    $datatables->edit('tic_id', function ($data) {
                        // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                         return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                        <i class="glyphicon glyphicon-option-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                            </a>
                                                                        </li>
									                                    <li>
                                                                             <a  href="javascript:void(0)" link="'.site_url('ticket/deleteticket/').encoding($data['tic_id']).'" class="deleteEntry">
                                                                              <span class="glyphicon glyphicon-trash"></span> Delete
                                                                             </a>
                                                                        </li>
                                                                        
                                                                    </ul><div>';
                    });

            echo $datatables->generate();
     }
    
     public function addticket_account(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){


            if($this->form_validation->run('add_ticket')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $tic_num =  rand(111,999);
                $ipaddress = $this->input->ip_address();

                $data = array(
                    'tic_number' => $tic_num, 
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    'user_id' => $createdby, 
                    'tic_users' => $this->input->post('tic_users'), 
                    'intended_user' => $this->input->post('role_id'), 
                    'tic_status' => $this->input->post('tic_status'), 
                    'tic_desc' => $this->input->post('tic_desc'), 
                    'tic_createdate' => $createddate, 
              
                );

                $query = $this->generalmodel->add('ticket_account',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            
            $data['category'] = $this->generalmodel->get_all_record('ticket_category');
            $data['users'] = $this->generalmodel->get_data_by_condition('rolename,urole_id','user_role',array('urole_id!='=>1));
            $data['countrylist'] = $this->generalmodel->countrylist();
            $this->load->view('addticket_account',$data);
        }
    }

    public function editticket_account($id)
    {   
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticket')){
               
                // $createddate = date('Y-m-d h:i:s');
                 // $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                    'tic_cat_id' => $this->input->post('tic_cat_id'), 
                    'tic_title' => $this->input->post('tic_title'), 
                    'tic_users' => $this->input->post('tic_users'), 
                    'tic_status' => $this->input->post('tic_status'), 
                    'tic_desc' => $this->input->post('tic_desc'), 
            
                );

                $query = $this->generalmodel->updaterecord('ticket_account',$data,'tic_id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Ticket Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            $data['category'] = $this->generalmodel->get_all_record('ticket_category');
            $data['ticket']=$this->generalmodel->getSingleRowById('ticket_account', 'tic_id', $id, $returnType = 'array');
            $this->load->view('editticket_account',$data);
        }
    }

     public function viewticket_account($id)
    {
        $id = decoding($id);
       $data['product']= $this->generalmodel->getsingleJoinData('*','ticket_account','ticket_category','ticket_account.tic_cat_id=ticket_category.tic_cat_id','tic_id='.$id);
       $this->load->view('viewticket_account',$data);
    }

    public function deleteticket_account($id)
    {   
        $id = decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('status'=>'0');
        		$this->generalmodel->updaterecord('ticket_account',$data,'tic_id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }

    public function ticketlic($id = '')
    {   
        $data['id'] = $id;
        $data['meta_title'] = "Ticket";
        $this->load->view('ticket/ticketlic',$data);
    }


    public function ajaxlic($id= '')
    {
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);

        if(!empty($this->session->userdata['licenseeid']))
        {
            $id=$this->session->userdata['licenseeid'];
            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$id.'"');
            }else
            {
                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$user_id.'"');

            }
        }

             $datatables->edit('business_name', function ($data) {
                    if($data['business_name']){
                        return $data['business_name']; 
                    }else{
                        return "-"; 
                    }
                });


            $datatables->edit('tic_status', function ($data) {
                    if($data['tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
                    // // edit 'id' column
                 $datatables->edit('tic_id', function($data) use($perms){
                    $uid = encoding($data['tic_id']);
                        $menu='';
                        if(in_array('TIC_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_DL',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/exportnote/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-download-alt"></span> Download
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

     public function ticketia($id='')
    {
        $data['id'] = $id;
         $data['meta_title'] = "Ticket";
        $this->load->view('ticket/ticketia',$data);
    }


    public function ajaxia($id = '')
   {
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);

       if(!empty($this->session->userdata['iaid']))
        {
            $id=$this->session->userdata['iaid']; 
            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$id.'"');
            }else
            {
                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$user_id.'"');

            }
        }

             $datatables->edit('business_name', function ($data) {
                    if($data['business_name']){
                        return $data['business_name']; 
                    }else{
                        return "-"; 
                    }
                });

            $datatables->edit('tic_status', function ($data) {
                    if($data['tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });
                    // // edit 'id' column
                $datatables->edit('tic_id', function($data) use($perms){
                    $uid = encoding($data['tic_id']);
                        $menu='';
                        if(in_array('TIC_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_DL',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/exportnote/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-download-alt"></span> Download
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


      public function ticketconsume()
    {
         $data['meta_title'] = "Ticket";
        $this->load->view('ticket/ticketconsume',$data);
    }


    public function ajaxconsume()
    {
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);
        if(!empty($this->session->userdata['customerid']))
        {
            $id=$this->session->userdata['customerid']; 
            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4"  AND m.user_id="'.$id.'"');
            }else
            {
                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4" AND m.user_id="'.$user_id.'"');

            }
        }

             $datatables->edit('business_name', function ($data) {
                    if($data['business_name']){
                        return $data['business_name']; 
                    }else{
                        return "-"; 
                    }
                });
                    // // edit 'id' column
             $datatables->edit('tic_status', function ($data) {
                    if($data['tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });

                  $datatables->edit('tic_id', function($data) use($perms){
                    $uid = encoding($data['tic_id']);
                        $menu='';
                        if(in_array('TIC_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_DL',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/exportnote/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-download-alt"></span> Download
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

      public function ticketsup()
    {
        $this->load->view('ticket/ticketsup');
    }


    public function ajaxsup()
    {
            $user_id = $this->userdata['user_id'];
            $perms=explode(",",$this->userdata['upermission']);
            $datatables = new Datatables(new CodeigniterAdapter);
           
            // $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5"');
            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5"');
            }else
            {
                 $datatables->query('SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5" AND m.user_id="'.$user_id.'"');

            }
                  
                   $datatables->edit('tic_status', function ($data) {
                    if($data['tic_status']=='0'){
                       $st= 'Open';
                    }else if($data['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($data['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
                        return $st; 
                });

                   $datatables->edit('tic_id', function($data) use($perms){
                    $uid = encoding($data['tic_id']);
                        $menu='';
                        if(in_array('TIC_VD',$perms)){
                            $menu.='<li>
                            <a href="'.site_url('ticket/viewticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_E',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/editticket/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                            </li>'; 
                        }

                        if(in_array('TIC_DL',$perms)){
                            $menu.='<li>
                           <a href="'.site_url('ticket/exportnote/').encoding($data['tic_id']).'">
                                <span class="glyphicon glyphicon-download-alt"></span> Download
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

/* Ticket Caltegory */

    public function addcategory(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            if($this->form_validation->run('add_ticcategory')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $data = array(
                     
                    'tic_cat_name' => $this->input->post('tic_cat_name'), 
                    'tic_parent_id' => $this->input->post('tic_parent_id'), 
                    'tic_cat_status' => '1', 
                    'tic_del_status' => '1', 
                    'tic_cat_createdby' => $createdby, 
                    'tic_cat_createdate' => $createddate, 
                   
                );

              
                $query = $this->generalmodel->add('ticket_category',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
            $data['category'] = $this->generalmodel->get_data_by_condition('tic_cat_name,tic_parent_id,tic_cat_id','ticket_category',array('tic_del_status'=>0,'tic_parent_id!='=>0));
            $data['countrylist'] = $this->generalmodel->countrylist();
            $this->load->view('ticket_category',$data);
        }
    }

     public function editcategory($id){

        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('edit_ticcategory')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $id =$this->input->post('id');
                $data = array(
                     
                    'tic_cat_name' => $this->input->post('tic_cat_name'), 
                    'tic_parent_id' => $this->input->post('tic_parent_id'), 
                    'tic_cat_status' => $this->input->post('tic_cat_status'), 
                   
                );

                $query = $this->generalmodel->updaterecord('ticket_category',$data,'tic_cat_id='.$id);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Ticket Category addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            // $data['category'] = $this->generalmodel->getRowAllById('product_category', 'createdby', '0', $orderby = 'prod_cat_id', $orderformat = 'asc');
            $data['category'] = $this->generalmodel->get_all_record('ticket_category');
            $data['cate']=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $id, $returnType = 'array');
            $data['countrylist'] = $this->generalmodel->countrylist();
            $this->load->view('editcategory',$data);
        }
    }
  
    public function category()
    {
        $this->load->view('ticket/category');
    }

    public function ajaxcate()
    {
        $datatables = new Datatables(new CodeigniterAdapter);
         $datatables->query('SELECT tic_cat_name,tic_parent_id,tic_cat_status,tic_cat_id FROM ticket_category WHERE tic_del_status!="0"');
       
    
                $datatables->edit('tic_cat_status', function ($data) {
                    if($data['tic_cat_status']=='1'){
                       $st= 'Active';
                    }else{
                       $st= 'Inactive';
                    }
                        return $st; 
                });

                // // edit 'id' column
                $datatables->edit('tic_cat_id', function ($data) {
                  

                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url('ticket/viewcategory/').encoding($data['tic_cat_id']).'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url('ticket/editcategory/').encoding($data['tic_cat_id']).'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a  href="javascript:void(0)" link="'.site_url('ticket/deletecate/').encoding($data['tic_cat_id']).'" class="deleteEntry">
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });

        echo $datatables->generate();
    }

    public function deletecate($id)
    {   
        $id =decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('tic_del_status'=>'0');
        		$this->generalmodel->updaterecord('ticket_category',$data,'tic_cat_id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }

    public function viewcategory($id)
    {
        $id =decoding($id);
        $data['cate']=$this->generalmodel->getSingleRowById('ticket_category', 'tic_cat_id', $id, $returnType = 'array');
         $this->load->view('viewcategory',$data);
    }

/*********** Add Note    ***********/
    public function addnote(){
        if($this->form_validation->run('add_ticnote')){
                
                 $createdate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                // $resource_id =  rand(111,999);
                $assign_to = $assign_date = '';
               

                $ipaddress = $this->input->ip_address();

                $data = array(
                    'tic_activity_title' => $this->input->post('tic_activity_title'), 
                    'tic_activity_des' => $this->input->post('tic_activity_des'), 
                    'tic_activity_createdate' =>  $createdate, 
                    'tic_activity_createdby' => $createdby, 
                    'tic_activity_createat' => 'ticket', 
                    // 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                    'tic_activity_ipaddress' =>$ipaddress, 
                    'tic_activity_platform' => $this->agent->platform(),
                    'tic_activity_webbrowser' => $this->agent->browser(), 
                    'tic_id'=>$this->input->post('id'),
                    'tic_activity_type'=>$this->input->post('tic_activity_type'),
                );

              $lastid = $this->generalmodel->add('ticket_activity', $data);
              if ($lastid) {
                 $return = array('success'=>true,'msg'=>'Activity Added Successfully');
                }else{
                   $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return);
    }

    public function viewnote()
    {
        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.tic_activity_title,b.firstname,b.lastname,m.tic_activity_des,m.tic_activity_createdate FROM ticket_activity as m LEFT JOIN user as b ON m.tic_activity_createdby = b.user_id WHERE m.tic_activity_createat ="ticket" ORDER BY m.tic_activity_createdate DESC');

         $datatables->edit('tic_activity_createdate', function ($data) {
                    return date('m/d/Y',strtotime($data['tic_activity_createdate']));
                });
         $datatables->edit('tic_activity_des', function ($data) {
            $desc = word_limiter($data['tic_activity_des'], 10);
            // return $desc.'......<a href="#addDesc" data-toggle="modal" id="addDesc">read more</a>';
            return $desc.'<a class="addDesc" data-id="desc" value="'.$data['tic_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>';
         });
     
        echo $datatables->generate();
    }

    public function exportlic()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            if(!empty($this->session->userdata['licenseeid']))
            {
                $id=$this->session->userdata['licenseeid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';
                }else
                {
                    $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$user_id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

                }
            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="2" AND status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{
             if(!empty($this->session->userdata['licenseeid']))
            {
                $id=$this->session->userdata['licenseeid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$id.'"';
                }else
                {
                    $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="2" AND m.user_id="'.$user_id.'"';

                }
            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket_account as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="2" AND m.status="1"';

        }

        
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $row['business_name'];
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];

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
             if(!empty($this->session->userdata['iaid']))
            {
                $id=$this->session->userdata['iaid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';
                }else
                {
                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$user_id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

                }
            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{
             if(!empty($this->session->userdata['iaid']))
            {
                $id=$this->session->userdata['iaid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$id.'"';
                }else
                {
                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="3" AND m.user_id="'.$user_id.'"';

                }
            }

             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket_account as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND m.status="1"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $row['business_name'];
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];

            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportsup()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){

            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';
            }else
            {
                 $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5" AND m.user_id="'.$user_id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{

            if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
            {

                 $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5"';
            }else
            {
                 $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="5" AND m.user_id="'.$user_id.'"';

            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket_account as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND m.status="1"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $row['business_name'];
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];

            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function exportconsume()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
             if(!empty($this->session->userdata['customerid']))
            {
                $id=$this->session->userdata['customerid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4" AND m.user_id="'.$id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';
                }else
                {
                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4" AND m.user_id="'.$user_id.'" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

                }
            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND status!="0" AND (m.tic_number LIKE "%'.$q.'%" OR m.tic_title LIKE "%'.$q.'%" OR b.tic_cat_name LIKE "%'.$q.'%")';

        }else{
            if(!empty($this->session->userdata['customerid']))
            {
                $id=$this->session->userdata['customerid'];
                if($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10)
                {

                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4" AND m.user_id="'.$id.'"';
                }else
                {
                     $items ='SELECT m.tic_title,m.tic_number,concat(u.firstname," ",u.lastname) as name,m.business_name,m.tic_status,b.tic_cat_name,m.tic_id FROM ticket as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id LEFT JOIN user as u ON m.user_id = u.user_id WHERE m.status!="0" AND u.urole_id="4" AND m.user_id="'.$user_id.'"';

                }
            }
             // $items = 'SELECT m.tic_number,m.tic_title,b.tic_cat_name,m.tic_id FROM ticket_account as m LEFT JOIN ticket_category as b ON m.tic_cat_id = b.tic_cat_id WHERE m.intended_user="3" AND m.status="1"';

        }
        
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Ticket.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Ticket Title'),
                WriterEntityFactory::createCell('Ticket Number'),
                WriterEntityFactory::createCell('Made By'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Category'),
                
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['tic_status']=='0'){
                       $st= 'Open';
                    }else if($row['tic_status']=='1'){
                       $st= 'Pending';
                    }else if($row['tic_status']=='2'){
                       $st= 'Resolved';
                    }else{
                       $st= 'Spam';
                    }
            $data[0] = $row['tic_title'];
            $data[1] = $row['tic_number'];
            $data[2] = $row['name'];
            $data[3] = $row['business_name'];
            $data[4] = $st;
            $data[5] = $row['tic_cat_name'];

            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

}
