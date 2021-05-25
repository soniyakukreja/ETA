<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH. 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;
class Kams extends MX_Controller {

   public function __construct(){
        parent::__construct();
        $this->userdata = $this->session->userdata('userdata');
    }
    
    public function index()
    {
        $data['meta_title']="KAMs & CSRs";
        $this->load->view('viewkams', $data);
    }


    public function ajaxkams()
    {
        
        $userid =$this->userdata['user_id'];
        $createdby=$this->userdata['createdby'];
        $datatables = new Datatables(new CodeigniterAdapter);
        if(!empty($this->session->userdata['licenseeid']))
        {
            $id=$this->session->userdata['licenseeid'];
            $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND k.urole_id="2" AND m.createdby='.$id.'');

        	// if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {

         //        $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND k.urole_id="2" AND m.createdby='.$id.'');
          
	        // }else{

	        //     $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND k.urole_id="2" AND m.createdby="'.$userid.'"');
	        // }
        }
        
        $datatables->edit('profilepicture', function ($data) {

            if($data['profilepicture']){
                return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
            }else{
                return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
            }
         });
        		$datatables->edit('ids', function ($data) {
        			return '<input type="checkbox" name="id[]" value="'.$data['user_id'].'" class="case">';
        		});

               $datatables->edit('createdate', function ($data) {
                    $localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['createdate'],$localtimzone);
                   
        			return date('m/d/Y',strtotime($createdate));
        		});
                // // edit 'id' column
                $datatables->edit('user_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a  href="javascript:void(0)" class="deleteEntry" link="'.site_url().'kams/Kams/delete/'.$data['user_id'].'" >
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });

        echo $datatables->generate();
    }

 	public function viewkamsia($id='')
    {
    	$data['meta_title'] = "KAMs & CSRs";
        $data['iaid'] = $id;
        $this->load->view('viewkamsla',$data);
    }

    public function viewkamslic($id='')
    {
        $data['meta_title'] = "KAMs & CSRs";
        $data['iaid'] = $id;
        $this->load->view('viewkams',$data);
    }

    public function ajaxkamsia($id='')
    {
        
        $userid =$this->userdata['user_id'];
        $datatables = new Datatables(new CodeigniterAdapter);
        /*if ($this->userdata['dept_id']==1 || $this->userdata['dept_id']==2 || $this->userdata['dept_id']==10) {
             if ($this->userdata['urole_id']==3) {
            
                 $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id="4" OR m.dept_id="5" AND m.urole_id="3" and m.createdby='.$userid.'');
            }else if ($this->userdata['urole_id']==2) {
                $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id="4" OR m.dept_id="5" AND m.urole_id="2" and m.createdby='.$userid.'');
            }else{

                $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id="4" OR m.dept_id="5" AND k.urole_id="3" and m.createdby='.$userid.'');
            }
        }else{

            $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id="4" OR m.dept_id="5" AND k.urole_id="3" AND m.createdby="'.$userid.'"');
        }*/
        /***GEtbyid***/
        if($id=='')
        {
        	if($this->userdata['urole_id']==1)
            $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3"');            
       	 else if($this->userdata['urole_id']==2)
            $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" and m.createdby='.$userid.'');
        }else{
        	if($this->userdata['urole_id']==1 || $this->userdata['urole_id']==2)

            $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" and m.createdby='.$id.'');
        }
        /***Close GETbyid***/
        // if($this->userdata['urole_id']==1)
        //     $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3"');            
        // else if($this->userdata['urole_id']==2)
        //     $datatables->query('SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" and m.createdby='.$userid.'');

            $datatables->edit('profilepicture', function ($data) {

                if($data['profilepicture']){
                    return '<img src="'.base_url().'uploads/user/'.$data['profilepicture'].'" style="width: 40px; height: 40px;">'; 
                }else{
                    return '<img src="'.base_url().'assets/img/avtr.png" style="width: 40px; height: 40px;">';
                }
            });

        		$datatables->edit('ids', function ($data) {
        			return '<input type="checkbox" name="id[]" value="'.$data['user_id'].'" class="case">';
        		});

               $datatables->edit('createdate', function ($data) {
        			$localtimzone =$this->userdata['timezone'];
                    $createdate = gmdate_to_mydate($data['createdate'],$localtimzone);
                   
                    return date('m/d/Y',strtotime($createdate));
        		});
                // // edit 'id' column
                $datatables->edit('user_id', function ($data) {
                    // return '<a href="http://127.0.0.1/Ethical/ETA/industryassociation/Industryassociation/ajax/'.$data['user_id'].'"> '.$data['user_id'].' </a> ';
                     return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                                    <i class="glyphicon glyphicon-option-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a  href="javascript:void(0)" class="deleteEntry" link="'.site_url().'kams/Kams/delete/'.$data['user_id'].'" >
                                                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul></div>';
                });

              


        echo $datatables->generate();
    }

    public function delete($id)
    {
	if ($this->input->is_ajax_request()) {

            $data = array('status'=>'0');
            $this->generalmodel->updaterecord('user',$data,'user_id='.$id);

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

            if($this->userdata['urole_id']==1)
                $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="2" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" OR k.firstname LIKE "%'.$q.'%" OR k.email LIKE "%'.$q.'%" OR m.createdate LIKE "%'.$q.'%")';            
            else if($this->userdata['urole_id']==2)
                $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="2" and m.createdby='.$userid.' AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" OR k.firstname LIKE "%'.$q.'%" OR k.email LIKE "%'.$q.'%" OR m.createdate LIKE "%'.$q.'%")';
            

        }else{

            if($this->userdata['urole_id']==1)
            $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="2"';            
            else if($this->userdata['urole_id']==2)
            $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="2" and m.createdby='.$userid.'';
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Kams.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Email Address'),
                WriterEntityFactory::createCell('Type'),
                WriterEntityFactory::createCell('Parent Name'),
                WriterEntityFactory::createCell('Parent Email'),
                WriterEntityFactory::createCell('Date Assigned'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[2] = $row['firstname'];
            $data[3] = $row['email'];
            $data[4] = $row['deptname'];
            $data[5] = $row['fname'];
            $data[6] = $row['mail'];
            $data[7] = $row['createdate'];
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

            if($this->userdata['urole_id']==1)
                $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" OR k.firstname LIKE "%'.$q.'%" OR k.email LIKE "%'.$q.'%" OR m.createdate LIKE "%'.$q.'%")';            
            else if($this->userdata['urole_id']==2)
                $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" and m.createdby='.$userid.' AND (m.resource_id LIKE "%'.$q.'%" OR m.firstname LIKE "%'.$q.'%" OR m.email LIKE "%'.$q.'%" OR b.deptname LIKE "%'.$q.'%" OR k.firstname LIKE "%'.$q.'%" OR k.email LIKE "%'.$q.'%" OR m.createdate LIKE "%'.$q.'%")';
            

        }else{

            if($this->userdata['urole_id']==1)
            $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3"';            
            else if($this->userdata['urole_id']==2)
            $items = 'SELECT m.user_id as ids,m.resource_id,m.profilepicture,m.firstname,m.email,b.deptname,k.firstname as fname,k.email as mail,m.createdate,m.user_id FROM user as m LEFT JOIN user as k ON m.createdby = k.user_id LEFT JOIN department as b ON m.dept_id = b.dept_id WHERE m.status="1" AND m.dept_id IN (4,5) AND m.urole_id="3" and m.createdby='.$userid.'';
        }
        

        $query=$this->db->query($items);
        $obj= $query->result_array();

        $writer = WriterEntityFactory::createXLSXWriter();
        $filePath = base_url().'Kams.xlsx';
        $writer->openToBrowser($filePath); // stream data directly to the browser
       $cells = [
                WriterEntityFactory::createCell('Resource ID'),
                WriterEntityFactory::createCell('Profile Picture'),
                WriterEntityFactory::createCell('Name'),
                WriterEntityFactory::createCell('Email Address'),
                WriterEntityFactory::createCell('Type'),
                WriterEntityFactory::createCell('Parent Name'),
                WriterEntityFactory::createCell('Parent Email'),
                WriterEntityFactory::createCell('Date Assigned'),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($cells);
        $writer->addRow($singleRow);
      
        foreach ($obj as $row) {
            $data[0] = $row['resource_id'];
            $data[1] = base_url().'uploads/user/'.$row['profilepicture'];
            $data[2] = $row['firstname'];
            $data[3] = $row['email'];
            $data[4] = $row['deptname'];
            $data[5] = $row['fname'];
            $data[6] = $row['mail'];
            $data[7] = date('m/d/Y',strtotime($row['createdate']));
            $writer->addRow(WriterEntityFactory::createRowFromArray($data));
        }
        $writer->close();
    }

    public function remove(){
        if ($this->input->is_ajax_request()) {
             $userid =$this->userdata['user_id'];
            $ids = $this->input->post('ids');
            $this->generalmodel->updaterecord('user',array('status'=>0,'updatedate'=>date('Y-m-d h:i:s'),'updatedby'=>$userid),'user_id IN('.$ids.')');
            $return = array('success'=>true,'msg'=>'Records Removed');
        }else{
            $return = array('success'=>false,'msg'=>'Internal Error');
        }
        echo json_encode($return);
    }
   
}
?>