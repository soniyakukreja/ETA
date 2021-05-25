<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Audience extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->userdata = $this->session->userdata('userdata');
 
	}

	public function index()
	{
        $data['meta_title'] = "Audience";
		$this->load->view('audience',$data);
	}

	public function ajax()
    {
    	
        $userid =$this->userdata['user_id'];
        $createdby =$this->userdata['createdby'];
        $perms=explode(",",$this->userdata['upermission']);
        $datatables = new Datatables(new CodeigniterAdapter);
        if($this->userdata['urole_id']==1)
			$datatables->query('SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=1');
		else if($this->userdata['urole_id']==2)
            $datatables->query('SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=2');
        else if($this->userdata['urole_id']==3)
            $datatables->query('SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=3');    
		$datatables->edit('status', function ($data) {
					if($data['status']){ return 'Active';}else{ return 'Inactive';}
        			
        		});
                  // // edit 'id' column
                $datatables->edit('id', function($data) use($perms){

                    $menu='';

                    if(in_array('AUD_VD',$perms)){
                        $menu.='<li>
                            <a href="'.site_url('audience/audiencedetail/').encoding($data['id']).'">
                                <span class="glyphicon glyphicon-eye-open"></span> View
                            </a>
                        </li>';
                    }

                    if(in_array('AUD_E',$perms)){
                        $menu.='<li>
                            <a href="'.site_url('audience/editaudience/').encoding($data['id']).'">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </li>';
                    }

                    if(in_array('AUD_D',$perms)){
                        $menu.='<li>
                            <a  href="javascript:void(0)" link="'.site_url('audience/deleteaudience/').encoding($data['id']).'" class="deleteEntry">
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

    public function addaudience(){

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){


            if($this->form_validation->run('addaudience')){
               
                $createddate = date('Y-m-d h:i:s');
                $createdby = $this->userdata['user_id'];
                $urole = $this->userdata['urole_id'];
               
                $data = array(
                    'name' => $this->input->post('name'), 
                    'email' => $this->input->post('email'), 
                    'businessname' => $this->input->post('businessname'), 
                    'createdby' => $createdby, 
                    'roles_id' => $urole, 
                    'status' => $this->input->post('status'), 
                    'createdate' => $createddate, 
              
                );

                $query = $this->generalmodel->add('audience',$data);
                if(!empty($query)){
                  
                    $return = array('success'=>true,'msg'=>'Audience addedd successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
        	 $data['category'] = $this->generalmodel->get_data_by_condition('urole_id,rolename','user_role',array('urole_id!='=>1));
              $data['meta_title'] = "Add Audience";
            $this->load->view('audience_form',$data);
        }
    }

    public function editaudience($id)
    {   
        $id = decoding($id);
        if(!empty($this->input->post()) && $this->input->is_ajax_request()){

            if($this->form_validation->run('editaudience')){
               
                $createddate = date('Y-m-d h:i:s');
                 $createdby = $this->userdata['user_id'];

                $id = $this->input->post('id');
                $data = array(
                    'name' => $this->input->post('name'), 
                    'email' => $this->input->post('email'), 
                    'businessname' => $this->input->post('businessname'), 
                    'modifyby' => $createdby, 
                    'intended_users' => $this->input->post('user'), 
                    'status' => $this->input->post('status'), 
                    'modifydate' => $createddate, 
              
                );

                $query = $this->generalmodel->updaterecord('audience',$data,'id='.$id);
                if(!empty($query)){
                   
                    $return = array('success'=>true,'msg'=>'Audience Updated successfully');
                }else{
                    $return = array('success'=>false,'msg'=>'something went wrong');
                }
            }else{
                $return = array('success'=>false,'msg'=>validation_errors());
            }
            echo json_encode($return); exit;
        }else{
           
            $data['category'] = $this->generalmodel->get_data_by_condition('urole_id,rolename','user_role',array('urole_id!='=>1));
            
            $data['ad']=$this->generalmodel->getSingleRowById('audience', 'id', $id, $returnType = 'array');
             $data['meta_title'] = "Edit Audience";
            $this->load->view('editaudience',$data);
        }
    }

     public function audiencedetail($id)
    {
        $id= decoding($id);
       $data['ad']= $this->generalmodel->getsingleJoinData('audience.id,audience.name,audience.businessname,audience.email,audience.status,user_role.rolename','audience','user_role','audience.roles_id=user_role.urole_id','id='.$id);
    //    echo $this->db->last_query(); 
    // print_r($data); exit;
        $data['meta_title'] = "View Audience";
       $this->load->view('viewaudience',$data);
    }

    public function deleteaudience($id)
    {
        $id= decoding($id);
		if ($this->input->is_ajax_request()) {
			$data = array('status'=>"2");
        		$this->generalmodel->updaterecord('audience',$data,'id='.$id);
			$return = array('success'=>true,'msg'=>'Entry Removed');
		}else{
			$return = array('success'=>false,'msg'=>'Internal Error');
		}
		echo json_encode($return);

    }

    public function export()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $userid =$this->userdata['user_id'];
        $perms=explode(",",$this->userdata['upermission']);
        $q = $this->input->post('search');
        
        if($q!=''){
            // $items = 'SELECT m.name,m.email,m.businessname,b.rolename,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE b.status !=2 AND (m.name LIKE "%'.$q.'%" OR m.businessname LIKE "%'.$q.'%" OR b.rolename "%'.$q.'%")';
                if($this->userdata['urole_id']==1)
                $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=1 AND (m.name LIKE "%'.$q.'%" OR m.businessname LIKE "%'.$q.'%" OR b.rolename "%'.$q.'%")';
            else if($this->userdata['urole_id']==2)
                $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=2 AND (m.name LIKE "%'.$q.'%" OR m.businessname LIKE "%'.$q.'%" OR b.rolename "%'.$q.'%")';
            else if($this->userdata['urole_id']==3)
               $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=3 AND (m.name LIKE "%'.$q.'%" OR m.businessname LIKE "%'.$q.'%" OR b.rolename "%'.$q.'%")'; 

        }else{
                if($this->userdata['urole_id']==1)
                $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=1';
            else if($this->userdata['urole_id']==2)
                $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=2';
            else if($this->userdata['urole_id']==3)
                $items = 'SELECT m.name,m.email,m.businessname,m.status,m.id FROM audience as m LEFT JOIN user_role as b ON m.roles_id = b.urole_id WHERE m.status !="2" and b.urole_id=3'; 
           
        }
          
        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Audience.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
        $cells = [
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Email'),
                WriterEntityFactory::createCell('Business Name'),
                // WriterEntityFactory::createCell('User'),
                WriterEntityFactory::createCell('Status'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
        //$writer->addRow(array('resource_id', 'lic_number', 'business_name', 'user_cat_name', 'Distributor Name','email','end date'));

        foreach ($obj as $row) {
           if($row['status']){ $st= 'Active';}else{ $st= 'Inactive';}
            $data[0] = $row['name'];
            $data[1] = $row['email'];
            $data[2] = $row['businessname'];
            // $data[3] = $row['rolename'];
            $data[3] = $st;
            
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function uploadcsv(){
        $data['meta_title'] = "Audience";
        $this->load->view('uploadcsv',$data);
    }

    public function importcsv(){

        $filename = $_FILES["file"]["tmp_name"];
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename, "r"); 
            $i=0;
            $return = array();
            $uploadData = $this->uploadDoc('file','./tmp_upload/',array('csv'));
            $filesname =  $uploadData['file_name'];

            while (($csvData = fgetcsv($file, 1000, ",")) !== FALSE) 
            {
                $html='';
                if($i==0)
                {
                    $data['filename'] = $filesname;
                    $data['fields'] = $csvData;
                    $html = $this->load->view('include/audience_csv',$data,true);
                    
                $return = array('success'=>true,'data'=>$html);
                }   
             
            
                $i++;
            }
            //move_uploaded_file($filename, './tmp_upload/'.$filesname);

            echo json_encode($return); exit;
        }  
    }


    public function import(){
        
        $dbfieldArr = $this->input->post('dbfield');
        $dbvalArr = $this->input->post('dbvalue');
        if(!empty($dbfieldArr)){
            
            foreach($dbfieldArr as $key=>$f){
                
                $fv = $dbvalArr[$key];

                switch($f) {
                  case 'name':
                  $b_col = $fv ;
                    break;
                  case 'email':
                  $cp_col = $fv ;
                    break;
                  case 'business_name':
                  $ce_col = $fv ;
                    break;
                  
                }    
            }

            $file = $fname = $this->input->post('csv');
            $filename = './tmp_upload/'.$file;
            $file = fopen($filename, "r"); 

            $i=0;
            $uploadall =true;
            $return = array();
            $bData= $userData=array();
            $createddate = $updatedate = date('Y-m-d h:i:s');
            $createdby = $this->userdata['user_id'];
            $roleid = $this->userdata['urole_id'];
            $contactCount = 0;
            $busCount = 0;
            $contact = true;
            while (($csvData = fgetcsv($file, 1000, ",")) !== FALSE){
                if($i!=0){
                    $name = trim($csvData[$b_col]);
                    $email = trim($csvData[$cp_col]);
                    $bus_name = trim($csvData[$ce_col]);
                    
                    if(!empty($bus_name)){ 

                            $bData['name'] = $name;
                            $bData['email'] = $email;
                            $bData['businessname'] = $bus_name;
                            $bData['roles_id'] = $roleid;
                            $bData['createdate'] = $createddate;
                            $bData['createdby'] = $createdby;
                            $bData['modifyby'] = $createdby;
                            $bData['modifydate'] = $createddate;
                            
                            $business_id = $this->generalmodel->add('audience',$bData);
                            if(!empty($business_id)){
                                $busCount++;
                            }
                       
                    }
                }

                $i++; 
            }

            if($busCount>0){
                unlink('./tmp_upload/'.$fname);
                $return = array('success'=>true,'msg'=>'CSV File Uploaded successfully');
            }else{
                $return = array('success'=>false,'msg'=>'Already Uploaded');
            }
            echo json_encode($return); exit;
        }

    }

}