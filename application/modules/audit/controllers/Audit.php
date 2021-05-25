<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Audit extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
		
	}

	public function index()
	{
		$data['meta_title'] = 'Audit';
        $this->load->view('audit',$data);
	}

	public function ajax()
    {
    	
        $userid =$this->userdata['user_id'];
        $s_detail = $this->generalmodel->supplier_detail($userid);

        $createdby =$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);
        if($this->userdata['urole_id']==1){
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au';
        }elseif($this->userdata['urole_id']==2){

            $where = '(1=1)';
            if($this->userdata['dept_id']==2){
                $where = 'o.lic_id ='.$userid;
            }elseif($this->userdata['dept_id']==4 || $this->userdata['dept_id']==5){

                $where = 'o.lic_id ='.$this->userdata['createdby'];
            }

            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN orders as o ON au.orders_id=o.orders_id
            WHERE '.$where;
        }elseif($this->userdata['urole_id']==3){

            $where = '(1=1)';
            if($this->userdata['dept_id']==2){
                $where = 'o.ia_id ='.$userid;
            }elseif($this->userdata['dept_id']==4 || $this->userdata['dept_id']==5){

                $where = 'o.ia_id ='.$this->userdata['createdby'];
            }

            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN orders as o ON au.orders_id=o.orders_id
            WHERE '.$where;
        }elseif($this->userdata['urole_id']==5){
            $query = 'SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id 
            FROM audit as m 
            LEFT JOIN product as b ON m.prod_id = b.prod_id WHERE b.prod_del="1" AND b.supplier_id="'.$s_detail['supplier_id'].'"';
        }


		$datatables->query($query);
		$datatables->edit('updatedate', function ($data) {
                    if($data['updatedate']=='0000-00-00 00:00:00'){
                        return '-';
                    }else{
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
        			// return date('m/d/Y',strtotime($data['updatedate']));
                    }
        		});

        $datatables->edit('status', function ($data) {
            if($data['status']==0){ return 'Pending Audit'; }
            elseif($data['status']==1){ return 'Pending Review'; }
            elseif($data['status']==2){ if($this->userdata['urole_id']==4){  return 'Pending Review'; }else{  return 'Pending Certificate'; } }
            elseif($data['status']==3){ return 'Approved'; } 
            elseif($data['status']==4){ return 'Denied'; } 
           
        });

        $datatables->edit('ord_prod_id', function ($data) {

            $menu = '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class="glyphicon glyphicon-option-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="'.site_url('audit/viewaudit/').encoding($data['ord_prod_id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';
        if($this->userdata['urole_id']==1 && ($data['status']==2||$data['status']==4) && ($this->userdata['dept_id']==2 || $this->userdata['dept_id']==4 || $this->userdata['dept_id']==5) ){
            $menu .= '<li>
                <a href="'.site_url('audit/editaudit/').encoding($data['ord_prod_id']).'">
                    <span class="glyphicon glyphicon-pencil"></span> Edit
                </a>
            </li>';
        }elseif($this->userdata['urole_id']==5 && ($data['status']==0||$data['status']==1||$data['status']==4)){
            $menu .= '<li>
                <a href="'.site_url('audit/editaudit/').encoding($data['ord_prod_id']).'">
                    <span class="glyphicon glyphicon-pencil"></span> Edit
                </a>
            </li>';            
        }

        return $menu.'</ul></div>';

        });
 		echo $datatables->generate();
   
    }

    public function addaudit()
    {
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){


            if($this->form_validation->run('addaudit')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
               

               if(!empty($_FILES['file']['name'])){
                    $fileData = $this->uploadDoc('file','./uploads/audit_file',array('pdf'));
                    
                    if(empty($fileData['error'])){
                        $filename = $fileData['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename = '';
                }

                if(!empty($_FILES['certificate_file']['name'])){
                    $fileData1 = $this->uploadDoc('certificate_file','./uploads/audit_file/certificate',array('pdf'));
                    
                    if(empty($fileData1['error'])){
                        $filename1 = $fileData1['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData1['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename1 = '';
                }

                $data = array(
                    // 'ord_prod_id'=>'1',
                    'orders_id'=>'1',
                    'prod_id'=>'1',
                    'prod_name'=>'test',
                    'audit_num'=>'12346',
                    'businessname' => $this->input->post('businessname'), 
                    'status' => $this->input->post('status'), 
                    'createdate' => $createddate, 
                    'updatedate' => $createddate,
                    'file'=>$filename,
                    'certificate_file'=>$filename1,
                    'issue_date'=>date('Y-m-d',strtotime($this->input->post('issue_date'))), 
                    'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
              
                );



                $query = $this->generalmodel->add('audit',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Audit addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
             $data['category'] = $this->generalmodel->get_data_by_condition('urole_id,rolename','user_role',array('urole_id!='=>1));
             $data['meta_title'] = 'Add Audit';
            $this->load->view('audit_form');
        }
        
    }

    public function editaudit($id)
    {   
        $id = decoding($id);

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('editaudit')){
               
                $createddate = date('Y-m-d h:i:s');
                 $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');

               if(!empty($_FILES['file']['name'])){
                    $fileData = $this->uploadDoc('file','./uploads/audit_file',array('pdf'));
                    
                    if(empty($fileData['error'])){
                        $filename = $fileData['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename = '';
                }

                if(!empty($_FILES['certificate_file']['name'])){
                    $fileData1 = $this->uploadDoc('certificate_file','./uploads/audit_file/certificate',array('pdf'));
                    
                    if(empty($fileData1['error'])){
                        $filename1 = $fileData1['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData1['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename1 = '';
                }

                $data = array(
                    'status' => $this->input->post('status'), 
                    'updatedate'=>$createddate,
                    // 'file'=>$filename,
                    // 'certificate_file'=>$filename1,
                    // 'issue_date'=>date('Y-m-d',strtotime($this->input->post('issue_date'))), 
                    // 'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
                );

                if($this->userdata['urole_id']==5){
                    $data['file'] = $filename;
                }else{
                    $data['certificate_file'] = $filename1;
                    $data['issue_date'] = date('Y-m-d',strtotime($this->input->post('issue_date')));
                    $data['end_date'] = date('Y-m-d',strtotime($this->input->post('end_date')));
                }




                $query = $this->generalmodel->updaterecord('audit',$data,'ord_prod_id='.$id);
//print_r($_POST);
                //echo $this->db->last_query(); 
                if($query>0){
                   
                    $return = array('success'=>true,'msg'=>'Audit Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            
            $data['ad']=$this->generalmodel->getSingleRowById('audit', 'ord_prod_id', $id, $returnType = 'array');
            $data['meta_title'] = 'Edit Audit';
            $this->load->view('editaudit',$data);
        }
    }

    public function editconaudit($id)
    {
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('editaudit')){
               
                $createddate = date('Y-m-d h:i:s');
                 $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');

               if(!empty($_FILES['file']['name'])){
                    $fileData = $this->uploadDoc('file','./uploads/audit_file',array('pdf'));
                    
                    if(empty($fileData['error'])){
                        $filename = $fileData['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename = '';
                }

                if(!empty($_FILES['certificate_file']['name'])){
                    $fileData1 = $this->uploadDoc('certificate_file','./uploads/audit_file/certificate',array('pdf'));
                    
                    if(empty($fileData1['error'])){
                        $filename1 = $fileData1['file_name'];
                    }else{
                        $return = array('success'=>false,'msg'=>$fileData1['error']);
                        echo json_encode($return); exit;
                    }
                }else{
                    $filename1 = '';
                }

                $data = array(
                   
                    'status' => $this->input->post('status'), 
                    'file'=>$filename,
                    'certificate_file'=>$filename1,
                    'updatedate'=>$createddate,
                    'issue_date'=>date('Y-m-d',strtotime($this->input->post('issue_date'))), 
                    'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
              
                );

                $query = $this->generalmodel->updaterecord('audit',$data,'ord_prod_id='.$id);
                if($query>0){
                   
                    $return = array('success'=>true,'msg'=>'Audit Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
            
            $data['ad']=$this->generalmodel->getSingleRowById('audit', 'ord_prod_id', $id, $returnType = 'array');
            $data['meta_title'] = 'Edit Audit';
            $this->load->view('editconaudit',$data);
        }
    }



    public function viewaudit($id)
    {   
        $id = decoding($id);
        $data['ad']=$this->generalmodel->audit_detail($id);
        $data['meta_title'] = 'View Audit';
        $this->load->view('viewaudit',$data);   
    }

    public function viewconaudit($id)
    {
        $data['ad']=$this->generalmodel->getSingleRowById('audit', 'ord_prod_id', $id, $returnType = 'array');
        $data['meta_title'] = 'View Audit';
        $this->load->view('viewconaudit',$data);   
    }

    public function export()
    {   
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $s_detail = $this->generalmodel->supplier_detail($userid);

        $perms=explode(",",$this->userdata['upermission']);

        $q = $this->input->post('search');
        
        // if($q!=''){
        //     $query = 'SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m 
        //     WHERE (m.audit_num LIKE "%'.$q.'%" OR m.businessname LIKE "%'.$q.'%" OR m.status "%'.$q.'%" OR m.updatedate "%'.$q.'%")';

        // }else{

        //     $query = 'SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m';
        // }

        if(!empty($this->input->post('consumer_id'))){
            $cid= $this->input->post('consumer_id');
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN orders as o ON au.orders_id=o.orders_id
            WHERE o.createdby ='.$cid;

        }elseif($this->userdata['urole_id']==1){
            //$query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id FROM audit as au WHERE au.status !="0"';
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id FROM audit as au';
        }elseif($this->userdata['urole_id']==2){
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN orders as o ON au.orders_id=o.orders_id
            WHERE o.lic_id ='.$userid;
        }elseif($this->userdata['urole_id']==3){
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN orders as o ON au.orders_id=o.orders_id
            WHERE o.ia_id ='.$userid;
        }elseif($this->userdata['urole_id']==5){
            $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
            FROM audit as au 
            LEFT JOIN product as b ON au.prod_id = b.prod_id WHERE b.prod_del=1 AND b.supplier_id="'.$s_detail['supplier_id'].'"';
        }
        

        if($q!=''){
            $query .=' AND (au.audit_num LIKE "%'.$q.'%" OR au.businessname LIKE "%'.$q.'%" OR au.status "%'.$q.'%" OR au.updatedate "%'.$q.'%")';
        }

        $query=$this->db->query($query);

        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Audit.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Audit Number'),
                WriterEntityFactory::createCell('Business Name'),
                WriterEntityFactory::createCell('Status'),
                WriterEntityFactory::createCell('Last Updated Date'),
              
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
            // if($row['status']==0){ $st= 'Pending Audit'; }
            // else if($row['status']==1){$st= 'Pending Review';}
            // else{ $st= 'Pending Certificate'; }

            if($row['status']==0){ $st= 'Pending Audit'; }
            elseif($row['status']==1){
                if($this->userdata['urole_id']==1){
                    $st= 'Pending Certificate'; 
                }else{
                    $st= 'Pending Review'; 
                }
            }
            elseif($row['status']==2){ $st= 'Approved'; } 
            elseif($row['status']==3){ $st= 'Denied'; } 


            if($row['updatedate']=='0000-00-00 00:00:00'){
                $date= '';
            }else{
                $localtimzone =$this->userdata['timezone'];
                $createdate = gmdate_to_mydate($row['updatedate'],$localtimzone);
                $date= date('m/d/Y',strtotime($createdate));
            }
            $data[0] = $row['audit_num'];
            $data[1] = $row['businessname'];
            $data[2] = $st;
            $data[3] = $date;
           
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function consumeraudit()
    {
        $data['meta_title'] = 'Audit';
        $this->load->view('auditconsumer',$data);
    }

    public function auditia()
    {
        $data['meta_title'] = 'Audit';
        $this->load->view('auditia',$data);
    }

    public function ajaxbycon()
    {
        
        $userid =$this->session->userdata['customerid'];
        $createdby =$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);

        //$query = 'SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m LEFT JOIN orders_product as b ON m.ord_prod_id = b.ord_prod_id LEFT JOIN orders as c ON b.orders_id = c.orders_id WHERE c.createdby="'.$userid.'"';
        $query = 'SELECT au.audit_num,au.businessname,au.status,au.updatedate,au.ord_prod_id 
        FROM audit as au 
        LEFT JOIN orders as o ON au.orders_id=o.orders_id
        WHERE o.createdby ='.$userid;

        $datatables->query($query);
        
        $datatables->edit('updatedate', function ($data) {
                    if($data['updatedate']=='0000-00-00 00:00:00'){
                        return '0000-00-00';
                    }else{
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
                    // return date('m/d/Y',strtotime($data['updatedate']));
                    }
        });


        $datatables->edit('status', function ($data) {
            if($data['status']==0){ return 'Pending Audit'; }elseif($data['status']==1){ return 'Pending Review'; }else if($data['status']==2){return 'Approved';}elseif($data['status']==3){ return 'Denied'; } 
           
        });

        $datatables->edit('ord_prod_id', function ($data) {
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'audit/viewconaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url().'audit/editconaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });
        echo $datatables->generate();
   
    }

    public function ajaxbyia()
    {
        
        $userid =$this->session->userdata['iaid'];
        $createdby =$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query('SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m LEFT JOIN orders_product as b ON m.ord_prod_id = b.ord_prod_id LEFT JOIN orders as c ON b.orders_id = c.orders_id WHERE c.ia_id="'.$userid.'"');
        
        $datatables->edit('updatedate', function ($data) {
                    if($data['updatedate']=='0000-00-00 00:00:00'){
                        return '0000-00-00';
                    }else{
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
                    // return date('m/d/Y',strtotime($data['updatedate']));
                    }
        });

        $datatables->edit('status', function ($data) {
                    if($data['status']==0){ return 'Pending Audit'; }else if($data['status']==1){return 'Pending Review';}else{ return 'Pending Certificate'; } 
                   
                });

        $datatables->edit('ord_prod_id', function ($data) {
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'audit/viewaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url().'audit/editaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });
        echo $datatables->generate();
   
    }

    public function auditlic()
    {
        $data['meta_title'] = 'Audit';
        $this->load->view('auditlic',$data);
    }

    public function ajaxbylic()
    {
        
        $userid =$this->session->userdata['licenseeid'];
        $createdby =$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query('SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m LEFT JOIN orders_product as b ON m.ord_prod_id = b.ord_prod_id LEFT JOIN orders as c ON b.orders_id = c.orders_id WHERE c.lic_id="'.$userid.'"');
        
        $datatables->edit('updatedate', function ($data) {
                    if($data['updatedate']=='0000-00-00 00:00:00'){
                        return '0000-00-00';
                    }else{
                        $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
                    // return date('m/d/Y',strtotime($data['updatedate']));
                    }
        });

        $datatables->edit('status', function ($data) {
                    if($data['status']==0){ return 'Pending Audit'; }else if($data['status']==1){return 'Pending Review';}else{ return 'Pending Certificate'; } 
                   
                });

        $datatables->edit('ord_prod_id', function ($data) {
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'audit/viewaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url().'audit/editaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });
        echo $datatables->generate();
   
    }

     public function auditeta()
    {
        $data['meta_title'] = 'Audit';
        $this->load->view('auditia',$data);
    }

    public function ajaxbbyeta()
    {
        
        $userid =$this->userdata['user_id'];
        $createdby =$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);

        $datatables->query('SELECT m.audit_num,m.businessname,m.status,m.updatedate,m.ord_prod_id FROM audit as m');
        
        $datatables->edit('updatedate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['updatedate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
                    // return date('m/d/Y',strtotime($data['updatedate']));
                });

        $datatables->edit('status', function ($data) {
                    if($data['status']==0){ return 'Pending Audit'; }else if($data['status']==1){return 'Pending Review';}else{ return 'Pending Certificate'; } 
                   
                });

        $datatables->edit('ord_prod_id', function ($data) {
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="'.site_url().'audit/viewaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="'.site_url().'audit/editaudit/'.$data['ord_prod_id'].'">
                                                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });
        echo $datatables->generate();
   
    }

    public function addnote(){
        if($this->form_validation->run('add_note')){
                
                 $createdate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
               
                $ipaddress = $this->input->ip_address();

                $data = array(
                    'app_activity_title' => $this->input->post('app_activity_title'), 
                    'app_activity_des' => $this->input->post('app_activity_des'), 
                    'app_activity_createdate' =>  $createdate, 
                    'app_activity_createdby' => $createdby, 
                    'app_activity_createat' => 'audit', 
                    // 'app_activity_createat' => 'lic-'.$this->input->post('lic_id'), 
                    'ord_prod_id' => $this->input->post('ord_prod_id'), 
                    'app_activity_ipaddress' =>$ipaddress, 
                    'app_activity_platform' => $this->agent->platform(),
                    'app_activity_webbrowser' => $this->agent->browser(), 
                );

              $lastid = $this->generalmodel->add('app_activity', $data);
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
        $ord_prod_id = $this->input->post('ord_prod_id');
        $this->load->helper('text');
        $datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('SELECT m.app_activity_title,concat(b.firstname," ",b.lastname) as name,m.app_activity_des,m.app_activity_createdate FROM app_activity as m LEFT JOIN user as b ON m.app_activity_createdby = b.user_id WHERE m.app_activity_createat ="audit" AND m.ord_prod_id="'.$ord_prod_id.'"');

        $datatables->edit('app_activity_createdate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['app_activity_createdate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
                    // return date('m/d/Y',strtotime($data['app_activity_createdate']));
                });

        $datatables->edit('app_activity_des', function ($data) {
            $desc = word_limiter($data['app_activity_des'], 10);
            $readmore ='<a class="addDesc" data-id="desc" value="'.$data['app_activity_des'].'"><span class="badge badge-pill badge-secondary">Read More</span></a>'; 
            if(strlen($data['app_activity_des'])>100){
                return $desc.$readmore;
            }else{ return $desc; }
            
         });
        echo $datatables->generate();
    }

}
?>